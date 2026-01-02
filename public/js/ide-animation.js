        // Theme Toggle
        const themeToggle = document.getElementById('theme-toggle');
        const sunIcon = document.getElementById('theme-icon-sun');
        const moonIcon = document.getElementById('theme-icon-moon');
        const html = document.documentElement;
        
        // Check for saved theme preference or default to dark
        const currentTheme = localStorage.getItem('theme') || 'dark';
        if (currentTheme === 'light') {
            html.setAttribute('data-theme', 'light');
            sunIcon.classList.remove('hidden');
            moonIcon.classList.add('hidden');
        }
        
        themeToggle.addEventListener('click', () => {
            const theme = html.getAttribute('data-theme');
            if (theme === 'light') {
                html.removeAttribute('data-theme');
                localStorage.setItem('theme', 'dark');
                sunIcon.classList.add('hidden');
                moonIcon.classList.remove('hidden');
            } else {
                html.setAttribute('data-theme', 'light');
                localStorage.setItem('theme', 'light');
                sunIcon.classList.remove('hidden');
                moonIcon.classList.add('hidden');
            }
            // Update IDE background
            if (typeof drawCode === 'function') {
                drawCode();
                texture.needsUpdate = true;
            }
        });
        
        // Scene setup
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, 1, 0.1, 1000);
        const canvas = document.getElementById('ide-canvas');
        if (canvas) {
            const renderer = new THREE.WebGLRenderer({ 
                canvas: canvas,
                alpha: true,
                antialias: true 
            });
            
            const container = canvas.parentElement;
            renderer.setSize(container.offsetWidth, container.offsetHeight);
            camera.position.z = 5;
            
            // Create IDE screen
            const screenGeometry = new THREE.PlaneGeometry(4, 3);
            
            // Create canvas texture for code
            const codeCanvas = document.createElement('canvas');
            codeCanvas.width = 1024;
            codeCanvas.height = 768;
            const ctx = codeCanvas.getContext('2d');
            
            // Code snippets with enhanced visibility
            const codeSnippets = [
                {
                    title: 'Laravel',
                    code: [
                        'Route::get(\'/api/users\', function() {',
                        '    return User::with(\'posts\')',
                        '        ->where(\'active\', true)',
                        '        ->paginate(15);',
                        '});'
                    ],
                    color: '#FF2D20',
                    keywords: ['Route', 'return', 'where', 'true']
                },
                {
                    title: 'Solidity',
                    code: [
                        'contract DevCleon {',
                        '    mapping(address => uint) balances;',
                        '    ',
                        '    function transfer(address to, uint amt)',
                        '        public returns (bool) { ... }',
                        '}'
                    ],
                    color: '#363636',
                    keywords: ['contract', 'mapping', 'function', 'public', 'returns', 'bool']
                },
                {
                    title: 'Flutter',
                    code: [
                        'class MyApp extends StatelessWidget {',
                        '  @override',
                        '  Widget build(BuildContext context) {',
                        '    return MaterialApp(',
                        '      home: Scaffold(...)',
                        '    );',
                        '  }',
                        '}'
                    ],
                    color: '#02569B',
                    keywords: ['class', 'extends', 'override', 'return']
                },
                {
                    title: 'Java',
                    code: [
                        'public class Application {',
                        '    public static void main(String[] args) {',
                        '        SpringApplication.run(',
                        '            Application.class, args',
                        '        );',
                        '    }',
                        '}'
                    ],
                    color: '#007396',
                    keywords: ['public', 'class', 'static', 'void']
                }
            ];
            
            let currentSnippet = 0;
            
            function getThemeColors() {
                const isLight = html.getAttribute('data-theme') === 'light';
                return {
                    bg: isLight ? '#ffffff' : '#1e1e1e',
                    headerBg: isLight ? '#f3f4f6' : '#2d2d30',
                    text: isLight ? '#1f2937' : '#e5e7eb',
                    lineNumbers: isLight ? '#9ca3af' : '#858585',
                    keyword: isLight ? '#0066cc' : '#569cd6',
                    string: isLight ? '#008000' : '#ce9178',
                    comment: isLight ? '#008000' : '#6a9955'
                };
            }
            
            window.drawCode = function() {
                const snippet = codeSnippets[currentSnippet];
                const colors = getThemeColors();
                
                // Background
                ctx.fillStyle = colors.bg;
                ctx.fillRect(0, 0, codeCanvas.width, codeCanvas.height);
                
                // Header bar
                ctx.fillStyle = colors.headerBg;
                ctx.fillRect(0, 0, codeCanvas.width, 60);
                
                // Window controls
                ctx.fillStyle = '#ff5f56';
                ctx.beginPath();
                ctx.arc(30, 30, 10, 0, Math.PI * 2);
                ctx.fill();
                
                ctx.fillStyle = '#ffbd2e';
                ctx.beginPath();
                ctx.arc(65, 30, 10, 0, Math.PI * 2);
                ctx.fill();
                
                ctx.fillStyle = '#27c93f';
                ctx.beginPath();
                ctx.arc(100, 30, 10, 0, Math.PI * 2);
                ctx.fill();
                
                // Title
                ctx.fillStyle = snippet.color;
                ctx.font = 'bold 28px monospace';
                ctx.fillText(snippet.title, 130, 38);
                
                // Code with syntax highlighting
                ctx.font = 'bold 26px "Courier New", monospace';
                snippet.code.forEach((line, i) => {
                    const y = 140 + i * 45;
                    
                    // Line numbers
                    ctx.fillStyle = colors.lineNumbers;
                    ctx.font = '22px monospace';
                    ctx.fillText((i + 1).toString().padStart(2, ' '), 20, y);
                    
                    // Code with keyword highlighting
                    ctx.font = 'bold 26px "Courier New", monospace';
                    let x = 80;
                    
                    // Split by words and highlight keywords
                    const words = line.split(/(\s+|[(){}[\];,.])/);
                    words.forEach(word => {
                        if (snippet.keywords.includes(word)) {
                            ctx.fillStyle = colors.keyword;
                        } else if (word.includes("'") || word.includes('"')) {
                            ctx.fillStyle = colors.string;
                        } else {
                            ctx.fillStyle = colors.text;
                        }
                        ctx.fillText(word, x, y);
                        x += ctx.measureText(word).width;
                    });
                });
            }
            
            drawCode();
            const texture = new THREE.CanvasTexture(codeCanvas);
            const screenMaterial = new THREE.MeshBasicMaterial({ map: texture });
            const screen = new THREE.Mesh(screenGeometry, screenMaterial);
            scene.add(screen);
            
            // Particles
            const particlesGeometry = new THREE.BufferGeometry();
            const particlesCount = 1000;
            const posArray = new Float32Array(particlesCount * 3);
            
            for(let i = 0; i < particlesCount * 3; i++) {
                posArray[i] = (Math.random() - 0.5) * 10;
            }
            
            particlesGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
            const particlesMaterial = new THREE.PointsMaterial({
                size: 0.02,
                color: 0x2563eb,
                transparent: true,
                opacity: 0.6
            });
            
            const particlesMesh = new THREE.Points(particlesGeometry, particlesMaterial);
            scene.add(particlesMesh);
            
            // Animation
            let rotation = 0;
            function animate() {
                requestAnimationFrame(animate);
                
                rotation += 0.005;
                screen.rotation.y = Math.sin(rotation) * 0.2;
                screen.rotation.x = Math.cos(rotation * 0.5) * 0.1;
                
                particlesMesh.rotation.y += 0.001;
                
                renderer.render(scene, camera);
            }
            
            animate();
            
            // Change code snippet every 3 seconds
            setInterval(() => {
                currentSnippet = (currentSnippet + 1) % codeSnippets.length;
                drawCode();
                texture.needsUpdate = true;
            }, 3000);
            
            // Handle resize
            window.addEventListener('resize', () => {
                const width = container.offsetWidth;
                const height = container.offsetHeight;
                renderer.setSize(width, height);
                camera.aspect = width / height;
                camera.updateProjectionMatrix();
            });
        }
        

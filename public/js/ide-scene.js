
// Ensure Three.js is loaded before running
document.addEventListener('DOMContentLoaded', () => {
    if (typeof THREE === 'undefined') {
        console.error('Three.js not loaded');
        return;
    }
    initScene();
});

function initScene() {
    const container = document.getElementById('ide-canvas-container');
    if (!container) return;

    // Scene Setup
    const scene = new THREE.Scene();
    
    // Camera
    const camera = new THREE.PerspectiveCamera(45, container.clientWidth / container.clientHeight, 0.1, 1000);
    camera.position.z = 5;

    // Renderer
    const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
    renderer.setSize(container.clientWidth, container.clientHeight);
    renderer.setPixelRatio(window.devicePixelRatio);
    container.appendChild(renderer.domElement);

    // Particle System
    const particleCount = 200;
    const geometry = new THREE.BufferGeometry();
    const positions = [];
    const colors = [];
    const blue = new THREE.Color('#2563EB');
    const red = new THREE.Color('#DC2626');

    for (let i = 0; i < particleCount; i++) {
        positions.push((Math.random() - 0.5) * 10); // x
        positions.push((Math.random() - 0.5) * 10); // y
        positions.push((Math.random() - 0.5) * 5);  // z
        
        const color = Math.random() > 0.5 ? blue : red;
        colors.push(color.r, color.g, color.b);
    }

    geometry.setAttribute('position', new THREE.Float32BufferAttribute(positions, 3));
    geometry.setAttribute('color', new THREE.Float32BufferAttribute(colors, 3));

    const particlesMaterial = new THREE.PointsMaterial({
        size: 0.05,
        vertexColors: true,
        transparent: true,
        opacity: 0.6
    });

    const particles = new THREE.Points(geometry, particlesMaterial);
    scene.add(particles);

    // IDE Window Group
    const ideGroup = new THREE.Group();
    scene.add(ideGroup);

    // Window Frame/Border (Glowing Blue)
    const frameGeometry = new THREE.BoxGeometry(3.6, 2.4, 0.1); // 5:3.8 ratio approx
    const frameMaterial = new THREE.MeshBasicMaterial({ color: 0x2563EB }); // Blue border base
    const frame = new THREE.Mesh(frameGeometry, frameMaterial);
    // Add glow effect using simple scaling mesh behind or shader (keeping simple for now)
    ideGroup.add(frame);

    // Screen Content (Canvas Texture)
    const screenWidth = 1024;
    const screenHeight = 768;
    const textCanvas = document.createElement('canvas');
    textCanvas.width = screenWidth;
    textCanvas.height = screenHeight;
    const ctx = textCanvas.getContext('2d');

    // Draw Code
    function drawCode() {
        // Background
        ctx.fillStyle = '#1e1e1e'; // VS Code dark
        ctx.fillRect(0, 0, screenWidth, screenHeight);

        // Header Bar
        ctx.fillStyle = '#252526';
        ctx.fillRect(0, 0, screenWidth, 40);
        
        // Window Controls
        ctx.fillStyle = '#FF5F56'; // Red
        ctx.beginPath(); ctx.arc(20, 20, 6, 0, Math.PI * 2); ctx.fill();
        ctx.fillStyle = '#FFBD2E'; // Yellow
        ctx.beginPath(); ctx.arc(45, 20, 6, 0, Math.PI * 2); ctx.fill();
        ctx.fillStyle = '#27C93F'; // Green
        ctx.beginPath(); ctx.arc(70, 20, 6, 0, Math.PI * 2); ctx.fill();

        // Code Content
        ctx.font = 'bold 28px Consolas, monospace';
        let y = 80;
        const x = 40;
        const lineHeight = 40;

        // PHP snippet
        ctx.fillStyle = '#569CD6'; // Blue keyword
        ctx.fillText('class', x, y);
        ctx.fillStyle = '#4EC9B0'; // Turquoise class name
        ctx.fillText(' PortfolioController', x + 90, y);
        ctx.fillStyle = '#D4D4D4'; // White text
        ctx.fillText(' extends', x + 400, y);
        ctx.fillStyle = '#4EC9B0';
        ctx.fillText(' Controller', x + 530, y);
        
        y += lineHeight;
        ctx.fillStyle = '#D4D4D4';
        ctx.fillText('{', x, y);
        
        y += lineHeight;
        ctx.fillStyle = '#C586C0'; // Purple control flow
        ctx.fillText('    public function', x, y);
        ctx.fillStyle = '#DCDCAA'; // Yellow method
        ctx.fillText(' index', x + 240, y);
        ctx.fillStyle = '#D4D4D4';
        ctx.fillText('()', x + 330, y);

        y += lineHeight;
        ctx.fillStyle = '#D4D4D4';
        ctx.fillText('    {', x, y);

        y += lineHeight;
        ctx.fillStyle = '#569CD6';
        ctx.fillText('        return', x + 60, y);
        ctx.fillStyle = '#DCDCAA';
        ctx.fillText(' view', x + 170, y);
        ctx.fillStyle = '#CE9178'; // Orange string
        ctx.fillText("('welcome');", x + 250, y);

        y += lineHeight;
        ctx.fillStyle = '#D4D4D4';
        ctx.fillText('    }', x, y);
        y += lineHeight;
        ctx.fillStyle = '#D4D4D4';
        ctx.fillText('}', x, y);

        // Separator
        y += lineHeight * 2;
        ctx.fillStyle = '#6A9955'; // Comment green
        ctx.fillText('// Solidity Smart Contract', x, y);
        
        y += lineHeight;
        ctx.fillStyle = '#569CD6';
        ctx.fillText('contract', x, y);
        ctx.fillStyle = '#4EC9B0';
        ctx.fillText(' DevOS', x + 140, y);
        ctx.fillStyle = '#D4D4D4';
        ctx.fillText(' {', x + 230, y);
        
        y += lineHeight;
        ctx.fillStyle = '#569CD6';
        ctx.fillText('    uint256', x + 60, y);
        ctx.fillStyle = '#D4D4D4';
        ctx.fillText(' public', x + 180, y);
        ctx.fillStyle = '#9CDCFE'; // Light blue var
        ctx.fillText(' buildCount;', x + 290, y);
        
        y += lineHeight;
        ctx.fillStyle = '#D4D4D4';
        ctx.fillText('}', x, y);

    }
    drawCode();

    const screenTexture = new THREE.CanvasTexture(textCanvas);
    const screenGeometry = new THREE.PlaneGeometry(3.4, 2.2); // Slightly smaller than frame
    const screenMaterial = new THREE.MeshBasicMaterial({ map: screenTexture });
    const screenMesh = new THREE.Mesh(screenGeometry, screenMaterial);
    screenMesh.position.z = 0.06; // push slightly in front of frame
    ideGroup.add(screenMesh);

    // Back of the screen
    const backGeometry = new THREE.PlaneGeometry(3.6, 2.4);
    const backMaterial = new THREE.MeshBasicMaterial({ color: 0x111111 });
    const backMesh = new THREE.Mesh(backGeometry, backMaterial);
    backMesh.rotation.y = Math.PI;
    backMesh.position.z = -0.06;
    ideGroup.add(backMesh);


    // Animation Loop
    let mouseX = 0;
    let mouseY = 0;

    document.addEventListener('mousemove', (event) => {
        mouseX = (event.clientX / window.innerWidth) * 2 - 1;
        mouseY = -(event.clientY / window.innerHeight) * 2 + 1;
    });

    const animate = () => {
        requestAnimationFrame(animate);

        // Rotate IDE Group slightly
        ideGroup.rotation.y = Math.sin(Date.now() * 0.001) * 0.1 + (mouseX * 0.1);
        ideGroup.rotation.x = Math.cos(Date.now() * 0.001) * 0.05 - (mouseY * 0.1);

        // Rotate Particles
        particles.rotation.y += 0.001;

        renderer.render(scene, camera);
    };

    animate();

    // Handle Resize
    window.addEventListener('resize', () => {
        camera.aspect = container.clientWidth / container.clientHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(container.clientWidth, container.clientHeight);
    });
}

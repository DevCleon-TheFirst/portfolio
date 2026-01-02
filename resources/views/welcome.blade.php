<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- SEO Meta Tags -->
    <title>DevCleon - Full Stack Developer | Laravel, Blockchain, Mobile Development</title>
    <meta name="description" content="Professional full-stack developer specializing in Laravel, Java, Flutter, and Solidity. Building scalable web applications, blockchain solutions, and mobile experiences.">
    <meta name="keywords" content="full stack developer, Laravel developer, blockchain developer, Solidity, Flutter, Java, React, web development, mobile development">
    <meta name="author" content="DevCleon">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url('/') }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('logo-transparent.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('logo-transparent.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('logo-transparent.png') }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="DevCleon - Full Stack Developer Portfolio">
    <meta property="og:description" content="Professional full-stack developer specializing in Laravel, Java, Flutter, and Solidity. Building scalable web applications, blockchain solutions, and mobile experiences.">
    <meta property="og:image" content="{{ asset('logo.jpg') }}">
    <meta property="og:site_name" content="DevCleon Portfolio">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url('/') }}">
    <meta name="twitter:title" content="DevCleon - Full Stack Developer Portfolio">
    <meta name="twitter:description" content="Professional full-stack developer specializing in Laravel, Java, Flutter, and Solidity.">
    <meta name="twitter:image" content="{{ asset('logo.jpg') }}">
    
    <!-- Structured Data (JSON-LD) -->
    @verbatim
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Person",
        "name": "DevCleon",
        "url": "/",
        "jobTitle": "Full Stack Developer",
        "description": "Professional full-stack developer specializing in Laravel, Java, Flutter, and Solidity",
        "knowsAbout": ["Laravel", "Java", "Flutter", "Solidity", "React", "Docker", "Blockchain", "Web Development", "Mobile Development"],
        "sameAs": []
    }
    </script>
    @endverbatim
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        :root {
            --bg-primary: #0a0a0a;
            --bg-secondary: #1a1a2e;
            --text-primary: #ffffff;
            --text-secondary: #94a3b8;
            --glass-bg: rgba(26, 26, 46, 0.4);
            --glass-border: rgba(59, 130, 246, 0.2);
            --gradient-1: rgba(59, 130, 246, 0.15);
            --gradient-2: rgba(136, 19, 55, 0.15);
            --accent-blue: #3b82f6;
            --accent-maroon: #881337;
        }
        
        [data-theme="light"] {
            --bg-primary: #f8fafc;
            --bg-secondary: #e0e7ff;
            --text-primary: #1e293b;
            --text-secondary: #475569;
            --glass-bg: rgba(255, 255, 255, 0.9);
            --glass-border: rgba(59, 130, 246, 0.2);
            --gradient-1: rgba(59, 130, 246, 0.08);
            --gradient-2: rgba(136, 19, 55, 0.08);
            --accent-blue: #2563eb;
            --accent-maroon: #9f1239;
        }
        
        body { 
            font-family: 'Inter', sans-serif; 
            background: var(--bg-primary);
            color: var(--text-primary);
            overflow-x: hidden;
            transition: background 0.3s ease, color 0.3s ease;
        }
        
        /* Gradient Background */
        .gradient-bg {
            background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 50%, var(--bg-primary) 100%);
            position: relative;
        }
        
        .gradient-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(59, 130, 246, 0.15) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(136, 19, 55, 0.15) 0%, transparent 50%);
            pointer-events: none;
        }
        
        /* Glassmorphism */
        .glass {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        [data-theme="light"] .glass {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        /* Animations */
        @@keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @@keyframes glow {
            0%, 100% { box-shadow: 0 0 20px rgba(37, 99, 235, 0.3); }
            50% { box-shadow: 0 0 40px rgba(37, 99, 235, 0.6); }
        }
        
        @@keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        @@keyframes slideInRight {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-glow { animation: glow 3s ease-in-out infinite; }
        .animate-slide-left { animation: slideInLeft 0.8s ease-out; }
        .animate-slide-right { animation: slideInRight 0.8s ease-out; }
        
        /* Three.js Canvas */
        #ide-canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            border-radius: 1rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        [data-theme="light"] #ide-canvas {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15),
                        inset 0 0 0 1px rgba(148, 163, 184, 0.1);
        }
        
        .canvas-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(136, 19, 55, 0.1) 100%);
            border-radius: 1rem;
            pointer-events: none;
            z-index: 2;
        }
        
        [data-theme="light"] .canvas-overlay {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(136, 19, 55, 0.05) 100%);
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #0a0a0a; }
        ::-webkit-scrollbar-thumb { background: #2563eb; border-radius: 5px; }
        ::-webkit-scrollbar-thumb:hover { background: #1d4ed8; }
        
        /* Hover Effects */
        .hover-lift {
            transition: all 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(37, 99, 235, 0.2);
        }
        
        [data-theme="light"] .hover-lift:hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(135deg, #3b82f6 0%, #881337 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
        }
        
        [data-theme="light"] .gradient-text {
            background: linear-gradient(135deg, #2563eb 0%, #9f1239 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Custom Cursor */
        .custom-cursor {
            width: 40px;
            height: 40px;
            border: 2px solid rgba(59, 130, 246, 0.5);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 9999;
            transition: all 0.1s ease;
            transform: translate(-50%, -50%);
        }
        
        .cursor-dot {
            width: 8px;
            height: 8px;
            background: #3b82f6;
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 9999;
            transform: translate(-50%, -50%);
        }
        
        .custom-cursor.cursor-hover {
            width: 60px;
            height: 60px;
            border-color: rgba(136, 19, 55, 0.8);
        }
        
        .cursor-dot.cursor-hover {
            width: 12px;
            height: 12px;
            background: #881337;
        }
        
        /* Glitch Effect */
        .glitch-active {
            animation: glitch 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94) both;
        }
        
        @@keyframes glitch {
            0%, 100% {
                transform: translate(0);
            }
            20% {
                transform: translate(-2px, 2px);
            }
            40% {
                transform: translate(-2px, -2px);
            }
            60% {
                transform: translate(2px, 2px);
            }
            80% {
                transform: translate(2px, -2px);
            }
        }
        
        /* Scroll Animations */
        .scroll-animate {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .scroll-animate.animate-in {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Enhanced Glow Effect */
        @@keyframes enhanced-glow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(59, 130, 246, 0.4),
                            0 0 40px rgba(136, 19, 55, 0.2);
            }
            50% {
                box-shadow: 0 0 40px rgba(59, 130, 246, 0.6),
                            0 0 60px rgba(136, 19, 55, 0.4);
            }
        }
        
        .animate-glow {
            animation: enhanced-glow 3s ease-in-out infinite;
        }
        
        /* Matrix Rain Background */
        @@keyframes matrix-fall {
            0% {
                transform: translateY(-100%);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(100vh);
                opacity: 0;
            }
        }
        
        /* Holographic Effect */
        .holographic {
            position: relative;
            overflow: hidden;
        }
        
        .holographic::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                45deg,
                transparent 30%,
                rgba(59, 130, 246, 0.1) 50%,
                transparent 70%
            );
            animation: holographic-shine 3s linear infinite;
        }
        
        @@keyframes holographic-shine {
            0% {
                transform: translateX(-100%) translateY(-100%) rotate(45deg);
            }
            100% {
                transform: translateX(100%) translateY(100%) rotate(45deg);
            }
        }
        
        /* Neumorphism */
        .neumorphic {
            background: var(--bg-secondary);
            box-shadow: 8px 8px 16px rgba(0, 0, 0, 0.3),
                        -8px -8px 16px rgba(255, 255, 255, 0.05);
        }
        
        [data-theme="light"] .neumorphic {
            box-shadow: 8px 8px 16px rgba(0, 0, 0, 0.1),
                        -8px -8px 16px rgba(255, 255, 255, 0.9);
        }
        
        /* Pulse Animation */
        @@keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.05);
                opacity: 0.8;
            }
        }
        
        /* Shimmer Effect */
        @@keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }
            100% {
                background-position: 1000px 0;
            }
        }
        
        .shimmer {
            background: linear-gradient(
                90deg,
                transparent 0%,
                rgba(59, 130, 246, 0.2) 50%,
                transparent 100%
            );
            background-size: 1000px 100%;
            animation: shimmer 3s infinite;
        }
    
    </style>
</head>
<body class="gradient-bg">
    
    <!-- Navigation -->
    <nav class="w-full glass">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('logo.jpg') }}" alt="DevCleon Logo" class="w-20 h-20 rounded-full object-cover border-4 border-blue-500 shadow-2xl shadow-blue-500/70 hover:scale-110 transition-transform duration-300">
                    <span class="text-3xl font-bold gradient-text">DevCleon</span>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="hover:text-blue-500 transition" style="color: var(--text-secondary);">Home</a>
                    <a href="#projects" class="hover:text-blue-500 transition" style="color: var(--text-secondary);">Projects</a>
                    <a href="#skills" class="hover:text-blue-500 transition" style="color: var(--text-secondary);">Skills</a>
                    <a href="#contact" class="hover:text-blue-500 transition" style="color: var(--text-secondary);">Contact</a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Theme Toggle -->
                    <button id="theme-toggle" class="p-2 glass rounded-lg hover:bg-white/10 transition">
                        <svg id="theme-icon-sun" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <svg id="theme-icon-moon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="min-h-screen flex items-center justify-center relative overflow-hidden">
        <div class="absolute inset-0" id="ide-canvas-container"></div>
        
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center relative z-10">
            <!-- Left Content -->
            <div class="animate-slide-left space-y-8">
                <div class="inline-block px-4 py-2 glass rounded-full">
                    <span class="text-sm font-semibold gradient-text">🚀 Available for Freelance</span>
                </div>
                
                <h1 class="text-5xl md:text-7xl font-black leading-tight">
                    Building The
                    <span class="gradient-text block">Future</span>
                    One Line at a Time
                </h1>
                
                <p class="text-xl text-gray-400 leading-relaxed">
                    Full-stack developer specializing in scalable web applications, blockchain solutions, 
                    and cutting-edge mobile experiences. Transforming ideas into reality.
                </p>
                
                <div class="flex flex-wrap gap-3">
                    <span class="px-4 py-2 glass rounded-lg text-sm font-medium">Laravel</span>
                    <span class="px-4 py-2 glass rounded-lg text-sm font-medium">Java</span>
                    <span class="px-4 py-2 glass rounded-lg text-sm font-medium">Flutter</span>
                    <span class="px-4 py-2 glass rounded-lg text-sm font-medium">Solidity</span>
                    <span class="px-4 py-2 glass rounded-lg text-sm font-medium">React</span>
                    <span class="px-4 py-2 glass rounded-lg text-sm font-medium">Docker</span>
                </div>
                
                <div class="flex flex-wrap gap-4">
                    <a href="#projects" class="px-8 py-4 bg-gradient-to-r from-blue-600 to-rose-900 rounded-lg font-bold text-lg hover:opacity-90 transition animate-glow">
                        View Projects
                    </a>
                    <a href="#contact" class="px-8 py-4 glass rounded-lg font-bold text-lg hover:bg-white/10 transition">
                        Get in Touch
                    </a>
                    @php
                        $adminUser = \App\Models\User::where('email', 'hello@devcleon.site')->first();
                        $resumePath = $adminUser && $adminUser->resume_path ? Storage::url($adminUser->resume_path) : null;
                    @endphp
                    @if($resumePath)
                        <a href="{{ $resumePath }}" download="DevCleon-Resume.pdf" class="px-8 py-4 glass rounded-lg font-bold text-lg hover:bg-white/10 transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Download CV
                        </a>
                    @endif
                </div>
            </div>
            
            <!-- Right Content - Three.js IDE -->
            <div class="animate-slide-right hidden md:block">
                <div class="relative h-[600px] animate-float">
                    <canvas id="ide-canvas" class="rounded-2xl"></canvas>
                    <div class="canvas-overlay"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section id="projects" class="py-32 relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-black mb-4">Featured <span class="gradient-text">Projects</span></h2>
                <p class="text-xl text-gray-400">Showcasing my best work and innovations</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                @forelse($projects as $project)
                <div class="glass rounded-2xl overflow-hidden hover-lift holographic">
                    <div class="aspect-video bg-gradient-to-br from-blue-900/20 to-red-900/20 relative">
                        @if($project->image_path)
                            <img src="{{ asset('storage/' . $project->image_path) }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold mb-2">{{ $project->title }}</h3>
                        <p class="text-gray-400 mb-4">{{ Str::limit($project->problem ?? 'No description available', 100) }}</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            @if($project->tech_stack)
                                @foreach(array_slice($project->tech_stack, 0, 3) as $tech)
                            <span class="px-3 py-1 bg-blue-600/20 rounded-full text-xs">{{ $tech }}</span>
                                @endforeach
                            @endif
                        </div>
                        @if($project->project_url)
                        <a href="{{ $project->project_url }}" target="_blank" class="inline-flex items-center text-blue-400 hover:text-blue-300 transition">
                            View Project →
                        </a>
                        @elseif($project->github_url)
                        <a href="{{ $project->github_url }}" target="_blank" class="inline-flex items-center text-blue-400 hover:text-blue-300 transition">
                            View on GitHub →
                        </a>
                        @endif
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-400">No featured projects yet. Add some from the <a href="/dashboard/projects" class="text-blue-400 hover:text-blue-300">admin panel</a>.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Skills Section -->
    <section id="skills" class="py-32 relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-black mb-4">Technical <span class="gradient-text">Expertise</span></h2>
                <p class="text-xl text-gray-400">Technologies I work with daily</p>
            </div>
            
            <div class="grid md:grid-cols-4 gap-6">
                <div class="glass rounded-2xl p-8 text-center hover-lift">
                    <div class="text-5xl mb-4">⚡</div>
                    <h3 class="text-xl font-bold mb-2">Backend</h3>
                    <p class="text-gray-400 text-sm">Laravel, Node.js, Java Spring</p>
                </div>
                <div class="glass rounded-2xl p-8 text-center hover-lift">
                    <div class="text-5xl mb-4">🎨</div>
                    <h3 class="text-xl font-bold mb-2">Frontend</h3>
                    <p class="text-gray-400 text-sm">React, Vue, Tailwind CSS</p>
                </div>
                <div class="glass rounded-2xl p-8 text-center hover-lift">
                    <div class="text-5xl mb-4">📱</div>
                    <h3 class="text-xl font-bold mb-2">Mobile</h3>
                    <p class="text-gray-400 text-sm">Flutter, React Native</p>
                </div>
                <div class="glass rounded-2xl p-8 text-center hover-lift">
                    <div class="text-5xl mb-4">⛓️</div>
                    <h3 class="text-xl font-bold mb-2">Blockchain</h3>
                    <p class="text-gray-400 text-sm">Solidity, Web3.js, Ethers</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <section id="blog" class="py-32 relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-black mb-4">Latest <span class="gradient-text">Articles</span></h2>
                <p class="text-xl" style="color: var(--text-secondary);">Insights, tutorials, and thoughts on development</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Blog posts will be dynamically loaded -->
                <article class="glass rounded-2xl overflow-hidden hover-lift holographic">
                    <div class="aspect-video bg-gradient-to-br from-blue-900/20 to-red-900/20">
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="px-3 py-1 bg-blue-600/20 rounded-full text-xs font-semibold text-blue-400">
                                Tech
                            </span>
                            <span class="text-sm" style="color: var(--text-secondary);">
                                Jan 1, 2024
                            </span>
                        </div>
                        <h3 class="text-2xl font-bold mb-3" style="color: var(--text-primary);">Sample Blog Post</h3>
                        <p class="mb-4 line-clamp-3" style="color: var(--text-secondary);">
                            This is a sample blog post description. In a real application, this would be loaded from your database.
                        </p>
                        <a href="#" class="inline-flex items-center text-blue-400 hover:text-blue-300 transition font-semibold">
                            Read More →
                        </a>
                    </div>
                </article>
                
                <article class="glass rounded-2xl overflow-hidden hover-lift holographic">
                    <div class="aspect-video bg-gradient-to-br from-blue-900/20 to-red-900/20">
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="px-3 py-1 bg-blue-600/20 rounded-full text-xs font-semibold text-blue-400">
                                Laravel
                            </span>
                            <span class="text-sm" style="color: var(--text-secondary);">
                                Dec 15, 2023
                            </span>
                        </div>
                        <h3 class="text-2xl font-bold mb-3" style="color: var(--text-primary);">Laravel Tips & Tricks</h3>
                        <p class="mb-4 line-clamp-3" style="color: var(--text-secondary);">
                            Learn some advanced Laravel techniques to improve your development workflow.
                        </p>
                        <a href="#" class="inline-flex items-center text-blue-400 hover:text-blue-300 transition font-semibold">
                            Read More →
                        </a>
                    </div>
                </article>
                
                <article class="glass rounded-2xl overflow-hidden hover-lift holographic">
                    <div class="aspect-video bg-gradient-to-br from-blue-900/20 to-red-900/20">
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="px-3 py-1 bg-blue-600/20 rounded-full text-xs font-semibold text-blue-400">
                                Blockchain
                            </span>
                            <span class="text-sm" style="color: var(--text-secondary);">
                                Nov 30, 2023
                            </span>
                        </div>
                        <h3 class="text-2xl font-bold mb-3" style="color: var(--text-primary);">Getting Started with Solidity</h3>
                        <p class="mb-4 line-clamp-3" style="color: var(--text-secondary);">
                            A beginner's guide to smart contract development with Solidity on Ethereum.
                        </p>
                        <a href="#" class="inline-flex items-center text-blue-400 hover:text-blue-300 transition font-semibold">
                            Read More →
                        </a>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-32 relative">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-5xl font-black mb-6">Let's Build Something <span class="gradient-text">Amazing</span></h2>
                <p class="text-xl mb-12" style="color: var(--text-secondary);">Ready to bring your ideas to life? Let's talk.</p>
            </div>
            
            <div class="glass rounded-2xl p-8 md:p-12">
                <form id="contact-form" class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">Name</label>
                            <input type="text" id="name" name="name" required 
                                   class="w-full glass px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="Your name">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">Email</label>
                            <input type="email" id="email" name="email" required 
                                   class="w-full glass px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="your email">
                        </div>
                    </div>
                    <div>
                        <label for="subject" class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">Subject</label>
                        <input type="text" id="subject" name="subject" required 
                               class="w-full glass px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Project inquiry">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">Message</label>
                        <textarea id="message" name="message" rows="6" required 
                                  class="w-full glass px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="Tell me about your project"></textarea>
                    </div>
                    <button type="submit" 
                            class="w-full px-8 py-4 bg-gradient-to-r from-blue-600 to-rose-900 rounded-lg font-bold text-lg hover:opacity-90 transition">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </section>


    <!-- Footer -->
    <footer class="py-12 border-t border-white/10">
        <div class="max-w-7xl mx-auto px-6">
            @php
                $socialLinks = \App\Models\Setting::getSocialLinks();
            @endphp
            
            @if($socialLinks->isNotEmpty())
                <!-- Social Media Icons -->
                <div class="flex justify-center gap-6 mb-8">
                    @if($socialLinks->has('social_github'))
                        <a href="{{ $socialLinks['social_github'] }}" target="_blank" rel="noopener noreferrer" 
                           class="w-12 h-12 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-gradient-to-r hover:from-blue-600 hover:to-rose-900 hover:border-transparent transition-all duration-300 transform hover:scale-110">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                        </a>
                    @endif
                    
                    @if($socialLinks->has('social_facebook'))
                        <a href="{{ $socialLinks['social_facebook'] }}" target="_blank" rel="noopener noreferrer"
                           class="w-12 h-12 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-gradient-to-r hover:from-blue-600 hover:to-rose-900 hover:border-transparent transition-all duration-300 transform hover:scale-110">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                    @endif
                    
                    @if($socialLinks->has('social_whatsapp'))
                        <a href="{{ str_starts_with($socialLinks['social_whatsapp'], 'http') ? $socialLinks['social_whatsapp'] : 'https://wa.me/' . preg_replace('/[^0-9]/', '', $socialLinks['social_whatsapp']) }}" target="_blank" rel="noopener noreferrer"
                           class="w-12 h-12 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-gradient-to-r hover:from-blue-600 hover:to-rose-900 hover:border-transparent transition-all duration-300 transform hover:scale-110">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                        </a>
                    @endif
                    
                    @if($socialLinks->has('social_x'))
                        <a href="{{ $socialLinks['social_x'] }}" target="_blank" rel="noopener noreferrer"
                           class="w-12 h-12 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-gradient-to-r hover:from-blue-600 hover:to-rose-900 hover:border-transparent transition-all duration-300 transform hover:scale-110">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                    @endif
                    
                    @if($socialLinks->has('social_threads'))
                        <a href="{{ $socialLinks['social_threads'] }}" target="_blank" rel="noopener noreferrer"
                           class="w-12 h-12 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-gradient-to-r hover:from-blue-600 hover:to-rose-900 hover:border-transparent transition-all duration-300 transform hover:scale-110">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.186 24h-.007c-3.581-.024-6.334-1.205-8.184-3.509C2.35 18.44 1.5 15.586 1.472 12.01v-.017c.03-3.579.879-6.43 2.525-8.482C5.845 1.205 8.6.024 12.18 0h.014c2.746.02 5.043.725 6.826 2.098 1.677 1.29 2.858 3.13 3.509 5.467l-2.04.569c-1.104-3.96-3.898-5.984-8.304-6.015-2.91.022-5.11.936-6.54 2.717C4.307 6.504 3.616 8.914 3.589 12c.027 3.086.718 5.496 2.057 7.164 1.43 1.781 3.631 2.695 6.54 2.717 2.623-.02 4.358-.631 5.8-2.045 1.647-1.613 1.618-3.593 1.09-4.798-.31-.71-.873-1.3-1.634-1.75-.192 1.352-.622 2.446-1.284 3.272-.886 1.102-2.14 1.704-3.73 1.79-1.202.065-2.361-.218-3.259-.801-1.063-.689-1.685-1.74-1.752-2.964-.065-1.19.408-2.285 1.33-3.082.88-.76 2.119-1.207 3.583-1.291a13.853 13.853 0 013.02.142l-.126 1.974a11.881 11.881 0 00-2.68-.134c-1.112.063-1.953.39-2.502.97-.465.49-.702 1.08-.665 1.657.027.433.23.842.572 1.155.463.424 1.13.635 1.98.626 1.21-.065 2.108-.505 2.735-1.34.552-.734.86-1.746.918-3.01l.007-.16c.01-.184.015-.37.015-.556 0-1.833-.347-3.249-1.031-4.207-.684-.96-1.753-1.447-3.178-1.447-1.425 0-2.494.487-3.178 1.447-.684.958-1.031 2.374-1.031 4.207 0 1.833.347 3.249 1.031 4.207.684.96 1.753 1.447 3.178 1.447.684 0 1.307-.097 1.857-.29l.56 1.924c-.684.24-1.447.36-2.287.36-1.98 0-3.583-.684-4.774-2.032-1.19-1.348-1.79-3.178-1.79-5.455 0-2.277.6-4.107 1.79-5.455 1.191-1.348 2.794-2.032 4.774-2.032 1.98 0 3.583.684 4.774 2.032 1.19 1.348 1.79 3.178 1.79 5.455 0 .24-.007.477-.02.71.408.24.76.54 1.056.896.684.82 1.031 1.833 1.031 3.01 0 1.177-.347 2.19-1.031 3.01-.684.82-1.647 1.348-2.887 1.58-.408.077-.84.116-1.295.116z"/></svg>
                        </a>
                    @endif
                    
                    @if($socialLinks->has('social_linkedin'))
                        <a href="{{ $socialLinks['social_linkedin'] }}" target="_blank" rel="noopener noreferrer"
                           class="w-12 h-12 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-gradient-to-r hover:from-blue-600 hover:to-rose-900 hover:border-transparent transition-all duration-300 transform hover:scale-110">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                    @endif
                </div>
            @endif
            
            <!-- Copyright -->
            <p class="text-gray-400 text-center">&copy; {{ date('Y') }} DevCleon. All rights reserved.</p>
        </div>
    </footer>


    <!-- Three.js IDE Animation Script -->
    <script src="{{ asset('js/ide-animation.js') }}"></script>
    
    <!-- Advanced Effects Script -->
    <script src="{{ asset('js/advanced-effects.js') }}"></script>
    
    <!-- Contact Form Handler -->
    <script src="{{ asset('js/contact-form.js') }}"></script>
    
    <!-- Livewire Script -->
    <script src="https://cdn.jsdelivr.net/gh/livewire/livewire@v3.x.x/dist/livewire.min.js"></script>
</body>
</html>

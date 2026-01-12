<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'DevOS') }} - Dashboard</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('logo-transparent.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('logo-transparent.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('logo-transparent.png') }}">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <style>
        :root {
            /* Site Theme - Blue, Black, Maroon */
            --bg-main: #0a0a0a;
            --bg-card: #1a1a2e;
            --bg-card-hover: #252540;
            --border-color: rgba(59, 130, 246, 0.2);
            --accent-primary: #3b82f6; /* Blue */
            --accent-secondary: #881337; /* Maroon */
            --text-main: #FFFFFF;
            --text-muted: #94a3b8;
        }

        body {
            background-color: var(--bg-main);
            color: var(--text-main);
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        /* Gradient Text */
        .text-gradient {
            background: linear-gradient(135deg, #FFFFFF 0%, #94a3b8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .text-gradient-purple {
            background: linear-gradient(135deg, #3b82f6 0%, #881337 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Glass / Premium Cards */
        .premium-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .premium-card:hover {
            border-color: rgba(59, 130, 246, 0.4);
            transform: translateY(-2px);
            box-shadow: 0 10px 40px -10px rgba(59, 130, 246, 0.3);
        }

        /* Sidebar Nav */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 12px;
            color: var(--text-muted);
            transition: all 0.2s ease;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
        }

        .nav-item:hover {
            color: #FFFFFF;
            background: rgba(59, 130, 246, 0.1);
        }

        .nav-item.active {
            color: #FFFFFF;
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.15) 0%, rgba(136, 19, 55, 0.1) 100%);
            border: 1px solid rgba(59, 130, 246, 0.3);
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.2);
        }

        .nav-item.active svg {
            color: #3b82f6;
        }

        /* Premium Buttons */
        .btn-premium {
            background: linear-gradient(135deg, #3b82f6 0%, #881337 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(99, 102, 241, 0.3);
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        .btn-premium:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            box-shadow: 0 6px 25px rgba(99, 102, 241, 0.4);
        }

        /* CKEditor Custom Dark Theme */
        .ck-editor__editable {
            background-color: var(--bg-card) !important;
            border-color: var(--border-color) !important;
            color: var(--text-main) !important;
        }
        .ck.ck-toolbar {
            background-color: #1A1B21 !important;
            border-color: var(--border-color) !important;
        }
        .ck.ck-button {
            color: #d1d5db !important;
        }
        .ck.ck-button.ck-on, .ck.ck-button:hover {
            background-color: #6366f1 !important;
            color: white !important;
        }
        
    </style>
    @livewireStyles
</head>
<body class="bg-[#050505] text-white overflow-hidden">
    <div class="flex h-screen">
        <!-- Mobile Sidebar Overlay -->
        <div id="mobile-overlay" 
             class="fixed inset-0 bg-black/80 z-40 hidden md:hidden backdrop-blur-sm transition-opacity duration-300"
             onclick="toggleMobileMenu()"></div>

        <!-- Sidebar -->
        <aside id="sidebar" 
               class="fixed md:static inset-y-0 left-0 z-50 flex flex-col h-full border-r border-[#23242A] bg-[#0A0A0A] transition-transform duration-300 ease-in-out md:flex md:translate-x-0 -translate-x-full w-[280px]">
            
            <!-- Mobile Close Button (Absolute & Top-Level) -->
            <button onclick="toggleMobileMenu(event)" class="md:hidden absolute right-4 top-8 z-[9999] text-gray-400 hover:text-white transition-colors p-2 rounded-lg bg-[#0A0A0A]/90 backdrop-blur-md border border-[#23242A] cursor-pointer shadow-xl">
                <svg class="w-6 h-6 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <!-- Logo -->
            <div class="h-24 flex items-center justify-between px-6 transition-all duration-300 relative" id="sidebar-logo-container">
                <a href="{{ route('dashboard.index') }}" class="flex items-center gap-3">
                    <img src="{{ asset('logo.jpg') }}" alt="DevCleon Logo" class="w-10 h-10 rounded-full object-cover border-2 border-indigo-500/50 shadow-lg shadow-indigo-500/20 flex-shrink-0">
                    <div id="sidebar-logo-text" class="transition-opacity duration-200">
                        <h1 class="text-xl font-bold tracking-tight">DevCleon</h1>
                        <p class="text-[10px] text-gray-500 font-medium uppercase tracking-widest pl-0.5">Dashboard</p>
                    </div>
                </a>
            </div>

            <!-- Nav -->
            <nav class="flex-1 px-4 space-y-8 overflow-y-auto py-4 custom-scrollbar">
                <div class="space-y-1">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3 whitespace-nowrap overflow-hidden transition-all duration-300">Overview</p>
                    <div class="h-px w-8 bg-[#23242A] mx-auto mb-3 hidden md:hidden"></div> <!-- Hidden on desktop when open -->

                    <a href="{{ route('dashboard.index') }}" class="nav-item group">
                        <svg class="w-5 h-5 opacity-70 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        <span class="sidebar-text truncate transition-opacity duration-200">Dashboard</span>
                    </a>
                </div>

                <div class="space-y-1">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3 whitespace-nowrap overflow-hidden transition-all duration-300">Content</p>
                    
                    <a href="{{ route('dashboard.blog') }}" class="nav-item group">
                        <svg class="w-5 h-5 opacity-70 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        <span class="sidebar-text truncate transition-opacity duration-200">Blog Posts</span>
                    </a>
                    <a href="{{ route('dashboard.projects') }}" class="nav-item group">
                        <svg class="w-5 h-5 opacity-70 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                        <span class="sidebar-text truncate transition-opacity duration-200">Projects</span>
                    </a>
                    <a href="{{ route('dashboard.skills') }}" class="nav-item group">
                        <svg class="w-5 h-5 opacity-70 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                        <span class="sidebar-text truncate transition-opacity duration-200">Skills</span>
                    </a>
                    <a href="{{ route('dashboard.timeline') }}" class="nav-item group">
                        <svg class="w-5 h-5 opacity-70 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span class="sidebar-text truncate transition-opacity duration-200">Timeline</span>
                    </a>
                </div>

                <div class="space-y-1">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3 whitespace-nowrap overflow-hidden transition-all duration-300">Management</p>
                    
                    <a href="{{ route('dashboard.tasks') }}" class="nav-item group">
                        <svg class="w-5 h-5 opacity-70 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="sidebar-text truncate transition-opacity duration-200">Task Board</span>
                    </a>
                    <a href="{{ route('dashboard.focus') }}" class="nav-item group">
                        <svg class="w-5 h-5 opacity-70 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="sidebar-text truncate transition-opacity duration-200">Focus Timer</span>
                    </a>
                    <a href="{{ route('dashboard.accountability') }}" class="nav-item group">
                        <svg class="w-5 h-5 opacity-70 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        <span class="sidebar-text truncate transition-opacity duration-200">Project Planner</span>
                    </a>
                    <a href="{{ route('dashboard.messages') }}" class="nav-item group">
                        <svg class="w-5 h-5 opacity-70 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                        <span class="sidebar-text truncate transition-opacity duration-200">Messages</span>
                    </a>
                    <a href="{{ route('dashboard.contact-messages') }}" class="nav-item group">
                        <svg class="w-5 h-5 opacity-70 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span class="sidebar-text truncate transition-opacity duration-200">Contact Form</span>
                    </a>
                    <a href="{{ route('dashboard.settings') }}" class="nav-item group">
                        <svg class="w-5 h-5 opacity-70 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span class="sidebar-text truncate transition-opacity duration-200">Settings</span>
                    </a>
                    <a href="{{ route('dashboard.ip-blacklist') }}" class="nav-item group">
                        <svg class="w-5 h-5 opacity-70 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                        <span class="sidebar-text truncate transition-opacity duration-200">IP Blacklist</span>
                    </a>
                </div>
            </nav>

            <!-- User -->
            <div class="p-6 border-t border-[#23242A]">
                <div class="flex items-center gap-3" id="sidebar-user-container">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-gray-700 to-gray-600 border border-gray-500 flex items-center justify-center font-bold flex-shrink-0">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0 transition-opacity duration-200" id="sidebar-user-text">
                        <p class="text-sm font-semibold truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-gray-400">Pro Member</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" id="sidebar-logout-form">
                        @csrf
                        <button class="text-gray-500 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Content Area -->
        <main class="flex-1 overflow-hidden flex flex-col relative bg-[#050505] w-full">
            <!-- Top Gradient Mesh -->
            <div class="absolute top-0 left-0 w-full h-[300px] bg-gradient-to-b from-[#0F1119] to-transparent pointer-events-none"></div>
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-indigo-600/5 rounded-full blur-[100px] pointer-events-none"></div>

            <!-- Topbar (Search + Actions) -->
            <header class="h-20 md:h-24 px-4 md:px-8 flex items-center justify-between z-30 transition-all duration-300">
                <div class="flex items-center gap-4 flex-1">
                     <!-- Toggle Button -->
                    <button onclick="toggleSidebar()" class="text-gray-500 hover:text-white transition-colors p-2 rounded-lg hover:bg-[#1A1B21]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>

                    <div class="relative group flex-1 max-w-lg hidden md:block">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500 group-focus-within:text-indigo-400 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" placeholder="Search anything..." 
                            class="w-full bg-[#0F1014] border border-[#23242A] rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500/50 focus:ring-1 focus:ring-indigo-500/50 transition-all placeholder-gray-600 text-gray-300">
                    </div>
                </div>

                <div class="flex items-center gap-4 md:gap-6 pl-4 md:pl-8">
                    <livewire:dashboard.notifications-dropdown />
                    <div class="h-6 w-[1px] bg-[#23242A]"></div>
                    <button class="btn-premium px-4 py-2 md:px-6 md:py-2.5 text-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span class="hidden md:inline">Quick Action</span>
                        <span class="md:hidden">New</span>
                    </button>
                </div>
            </header>

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto px-4 md:px-8 pb-8 z-10 custom-scrollbar">
                {{ $slot }}
            </div>
        </main>
    </div>

    @livewireScripts
    <script>
        window.toggleSidebar = function() {
            if (window.innerWidth < 768) {
                toggleMobileMenu();
            } else {
                toggleDesktopMenu();
            }
        }

        window.toggleMobileMenu = function(e) {
            if(e) e.stopPropagation();
            
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-overlay');
            
            if (sidebar.classList.contains('-translate-x-full')) {
                // Open Mobile
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                overlay.classList.remove('hidden');
                // Force reflow
                void overlay.offsetWidth;
                overlay.classList.remove('opacity-0');
            } else {
                // Close Mobile
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
                overlay.classList.add('opacity-0');
                setTimeout(() => overlay.classList.add('hidden'), 300);
            }
        }

        window.toggleDesktopMenu = function() {
            const sidebar = document.getElementById('sidebar');
            // Logic remains same but ensure no errors
            try {
                const isExtended = sidebar.classList.contains('w-[280px]');
                
                if (isExtended) {
                    sidebar.classList.remove('w-[280px]');
                    sidebar.classList.add('w-[88px]');
                    
                    document.getElementById('sidebar-logo-text')?.classList.add('hidden');
                    document.getElementById('sidebar-user-text')?.classList.add('hidden');
                    document.getElementById('sidebar-logout-form')?.classList.add('hidden');
                    document.querySelectorAll('.sidebar-text').forEach(el => el.classList.add('hidden'));
                    document.querySelectorAll('.sidebar-section-label').forEach(el => el.classList.add('hidden'));
                    document.querySelectorAll('.sidebar-divider').forEach(el => el.classList.remove('hidden'));
                    
                    document.getElementById('sidebar-logo-container')?.classList.remove('justify-between', 'px-6');
                    document.getElementById('sidebar-logo-container')?.classList.add('justify-center', 'px-2');
                    document.getElementById('sidebar-user-container')?.classList.add('justify-center');
                    document.querySelectorAll('.nav-item').forEach(el => el.classList.add('justify-center', 'px-2'));
                } else {
                    sidebar.classList.remove('w-[88px]');
                    sidebar.classList.add('w-[280px]');
                    
                    document.getElementById('sidebar-logo-text')?.classList.remove('hidden');
                    document.getElementById('sidebar-user-text')?.classList.remove('hidden');
                    document.getElementById('sidebar-logout-form')?.classList.remove('hidden');
                    document.querySelectorAll('.sidebar-text').forEach(el => el.classList.remove('hidden'));
                    document.querySelectorAll('.sidebar-section-label').forEach(el => el.classList.remove('hidden'));
                    document.querySelectorAll('.sidebar-divider').forEach(el => el.classList.add('hidden'));
                    
                    document.getElementById('sidebar-logo-container')?.classList.add('justify-between', 'px-6');
                    document.getElementById('sidebar-logo-container')?.classList.remove('justify-center', 'px-2');
                    document.getElementById('sidebar-user-container')?.classList.remove('justify-center');
                    document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('justify-center', 'px-2'));
                }
            } catch(error) {
                console.error('Sidebar error:', error);
            }
        }
    </script>
</body>
</html>

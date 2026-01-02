<div class="space-y-8">
    <!-- Hero / Welcome Section -->
    <div class="relative overflow-hidden rounded-[24px] premium-card p-8 group">
         <!-- Geometric Background Patterns -->
        <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-gradient-to-br from-indigo-600/20 to-purple-600/5 rounded-full blur-[80px] -mr-20 -mt-20 group-hover:from-indigo-600/30 transition-all duration-700"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h2 class="text-3xl font-bold mb-2">
                    <span class="text-white">Welcome back,</span> <span class="text-gradient">{{ auth()->user()->name }}</span>
                </h2>
                <p class="text-gray-400 max-w-lg">Your workspace is ready. You have <span class="text-indigo-400 font-semibold">{{ $pendingTasks }} pending tasks</span> requiring your attention today.</p>
            </div>
            <div class="flex items-center gap-4">
                 <div class="bg-[#1A1B21] border border-[#23242A] rounded-xl px-4 py-2 flex flex-col items-end">
                     <span class="text-[10px] text-gray-500 uppercase font-bold tracking-wider">Discipline Score</span>
                     <span class="text-2xl font-bold text-gradient-purple">{{ number_format((float) auth()->user()->discipline_score, 1) }}</span>
                 </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid (Stakent Style) -->
    <div>
        <div class="flex items-center gap-4 mb-6">
            <h3 class="text-lg font-bold">Workspace Overview</h3>
            <div class="h-[1px] flex-1 bg-gradient-to-r from-[#23242A] to-transparent"></div>
            <div class="flex gap-2">
                <button class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-[#1A1B21] border border-[#23242A] text-gray-400 hover:text-white transition-colors">24H</button>
                <button class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-[#1A1B21] border border-[#23242A] text-gray-400 hover:text-white transition-colors">7D</button>
                <button class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-[#1A1B21] border border-[#23242A] text-gray-400 hover:text-white transition-colors">30D</button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Tasks Card -->
            <div class="premium-card p-6 relative overflow-hidden group">
                <div class="flex items-start justify-between mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-[#1A1B21] border border-[#23242A] flex items-center justify-center text-indigo-400 shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </div>
                    <span class="flex items-center gap-1 text-[10px] font-bold text-green-400 bg-green-500/10 px-2 py-1 rounded-full border border-green-500/10">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        +12%
                    </span>
                </div>
                <div>
                    <p class="text-sm text-gray-400 font-medium mb-1">Total Tasks</p>
                    <h3 class="text-3xl font-bold text-white tracking-tight">{{ $totalTasks }}</h3>
                </div>
                <!-- Simulated Chart Line -->
                <div class="mt-4 h-1 w-full bg-[#1A1B21] rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 w-[65%] rounded-full"></div>
                </div>
            </div>

            <!-- Projects Card -->
            <div class="premium-card p-6 relative overflow-hidden group">
                <div class="flex items-start justify-between mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-[#1A1B21] border border-[#23242A] flex items-center justify-center text-purple-400 shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm text-gray-400 font-medium mb-1">Active Projects</p>
                    <h3 class="text-3xl font-bold text-white tracking-tight">{{ $activeProjects }}</h3>
                </div>
                 <!-- Simulated Chart Line -->
                <div class="mt-4 h-1 w-full bg-[#1A1B21] rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-purple-500 to-pink-500 w-[45%] rounded-full"></div>
                </div>
            </div>

            <!-- Content Card -->
            <div class="premium-card p-6 relative overflow-hidden group">
                <div class="flex items-start justify-between mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-[#1A1B21] border border-[#23242A] flex items-center justify-center text-pink-400 shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm text-gray-400 font-medium mb-1">Blog Posts</p>
                    <h3 class="text-3xl font-bold text-white tracking-tight">{{ $totalBlogPosts }}</h3>
                </div>
                 <!-- Simulated Chart Line -->
                <div class="mt-4 h-1 w-full bg-[#1A1B21] rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-pink-500 to-red-500 w-[85%] rounded-full"></div>
                </div>
            </div>

            <!-- Messages Card -->
            <div class="premium-card p-6 relative overflow-hidden group">
                <div class="flex items-start justify-between mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-[#1A1B21] border border-[#23242A] flex items-center justify-center text-green-400 shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    @if($unreadMessages > 0)
                        <span class="relative flex h-3 w-3">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                        </span>
                    @endif
                </div>
                <div>
                    <p class="text-sm text-gray-400 font-medium mb-1">Unread Messages</p>
                    <h3 class="text-3xl font-bold text-white tracking-tight">{{ $unreadMessages }}</h3>
                </div>
                 <!-- Simulated Chart Line -->
                <div class="mt-4 h-1 w-full bg-[#1A1B21] rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-green-500 to-emerald-500 w-[10%] rounded-full"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Visitor Analytics Section -->
    <div>
        <div class="flex items-center gap-4 mb-6">
            <h3 class="text-lg font-bold">📊 Visitor Analytics</h3>
            <div class="h-[1px] flex-1 bg-gradient-to-r from-[#23242A] to-transparent"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Total Views Card -->
            <div class="premium-card p-6 relative overflow-hidden group">
                <div class="flex items-start justify-between mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-[#1A1B21] border border-[#23242A] flex items-center justify-center text-blue-400 shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm text-gray-400 font-medium mb-1">Total Page Views</p>
                    <h3 class="text-3xl font-bold text-white tracking-tight">{{ number_format($totalViews) }}</h3>
                </div>
                <div class="mt-4 h-1 w-full bg-[#1A1B21] rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-blue-500 to-cyan-500 w-full rounded-full"></div>
                </div>
            </div>

            <!-- Unique Visitors Card -->
            <div class="premium-card p-6 relative overflow-hidden group">
                <div class="flex items-start justify-between mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-[#1A1B21] border border-[#23242A] flex items-center justify-center text-purple-400 shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm text-gray-400 font-medium mb-1">Unique Visitors</p>
                    <h3 class="text-3xl font-bold text-white tracking-tight">{{ number_format($uniqueVisitors) }}</h3>
                </div>
                <div class="mt-4 h-1 w-full bg-[#1A1B21] rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-purple-500 to-pink-500 w-[{{ min(100, ($uniqueVisitors / max($totalViews, 1)) * 100) }}%] rounded-full"></div>
                </div>
            </div>

            <!-- Today's Views Card -->
            <div class="premium-card p-6 relative overflow-hidden group">
                <div class="flex items-start justify-between mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-[#1A1B21] border border-[#23242A] flex items-center justify-center text-green-400 shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm text-gray-400 font-medium mb-1">Today's Views</p>
                    <h3 class="text-3xl font-bold text-white tracking-tight">{{ number_format($todayViews) }}</h3>
                </div>
                <div class="mt-4 h-1 w-full bg-[#1A1B21] rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-green-500 to-emerald-500 w-[{{ min(100, ($todayViews / max($weekViews, 1)) * 100) }}%] rounded-full"></div>
                </div>
            </div>

            <!-- This Week Card -->
            <div class="premium-card p-6 relative overflow-hidden group">
                <div class="flex items-start justify-between mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-[#1A1B21] border border-[#23242A] flex items-center justify-center text-orange-400 shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm text-gray-400 font-medium mb-1">This Week</p>
                    <h3 class="text-3xl font-bold text-white tracking-tight">{{ number_format($weekViews) }}</h3>
                </div>
                <div class="mt-4 h-1 w-full bg-[#1A1B21] rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-orange-500 to-red-500 w-[{{ min(100, ($weekViews / max($totalViews, 1)) * 100) }}%] rounded-full"></div>
                </div>
            </div>
        </div>

        <!-- Popular Pages -->
        <div class="premium-card p-6">
            <h4 class="text-lg font-bold mb-4">🔥 Popular Pages</h4>
            <div class="space-y-3">
                @forelse($popularPages as $page)
                    <div class="flex items-center justify-between p-3 bg-[#1A1B21] rounded-lg border border-[#23242A] hover:border-blue-500/30 transition-colors">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-white truncate">{{ $page->url }}</p>
                        </div>
                        <div class="flex items-center gap-2 ml-4">
                            <span class="text-xs text-gray-400">{{ number_format($page->views) }} views</span>
                            <div class="w-20 h-2 bg-[#0F1014] rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-blue-500 to-purple-500 rounded-full" style="width: {{ min(100, ($page->views / $popularPages->max('views')) * 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-400 text-center py-4">No page views yet. Visit your homepage to start tracking!</p>
                @endforelse
            </div>
        </div>

        <!-- Device & Location Stats Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Device Types -->
            <div class="premium-card p-6">
                <h4 class="text-lg font-bold mb-4">📱 Device Types</h4>
                <div class="space-y-3">
                    @forelse($deviceStats as $device)
                        @php
                            $icons = [
                                'mobile' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>',
                                'desktop' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>',
                                'tablet' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>',
                            ];
                            $colors = [
                                'mobile' => 'from-green-500 to-emerald-500',
                                'desktop' => 'from-blue-500 to-cyan-500',
                                'tablet' => 'from-purple-500 to-pink-500',
                            ];
                            $totalDevices = $deviceStats->sum('count');
                            $percentage = $totalDevices > 0 ? ($device->count / $totalDevices) * 100 : 0;
                        @endphp
                        <div class="flex items-center justify-between p-3 bg-[#1A1B21] rounded-lg border border-[#23242A]">
                            <div class="flex items-center gap-3">
                                <div class="text-gray-400">
                                    {!! $icons[$device->device_type] ?? $icons['desktop'] !!}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-white capitalize">{{ $device->device_type }}</p>
                                    <p class="text-xs text-gray-400">{{ number_format($percentage, 1) }}%</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-sm text-gray-400">{{ number_format($device->count) }}</span>
                                <div class="w-24 h-2 bg-[#0F1014] rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r {{ $colors[$device->device_type] ?? 'from-gray-500 to-gray-600' }} rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-400 text-center py-4">No device data yet</p>
                    @endforelse
                </div>
            </div>

            <!-- Top Countries -->
            <div class="premium-card p-6">
                <h4 class="text-lg font-bold mb-4">🌍 Top Countries</h4>
                <div class="space-y-3">
                    @forelse($topCountries as $country)
                        @php
                            $totalCountries = $topCountries->sum('count');
                            $percentage = $totalCountries > 0 ? ($country->count / $totalCountries) * 100 : 0;
                        @endphp
                        <div class="flex items-center justify-between p-3 bg-[#1A1B21] rounded-lg border border-[#23242A]">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-white">{{ $country->country }}</p>
                                <p class="text-xs text-gray-400">{{ number_format($percentage, 1) }}% of visitors</p>
                            </div>
                            <div class="flex items-center gap-3 ml-4">
                                <span class="text-sm text-gray-400">{{ number_format($country->count) }}</span>
                                <div class="w-24 h-2 bg-[#0F1014] rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-orange-500 to-red-500 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-400 text-center py-4">No location data yet</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Split -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Tasks -->
        <div class="lg:col-span-2">
            <div class="premium-card min-h-[400px]">
                <div class="p-6 border-b border-[#23242A] flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-lg">Recent Tasks</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Your latest activity log</p>
                    </div>
                    <a href="{{ route('dashboard.tasks') }}" class="text-xs font-semibold text-indigo-400 hover:text-indigo-300 uppercase tracking-wide">View Board</a>
                </div>
                <div class="divide-y divide-[#23242A]">
                    @forelse($recentTasks as $task)
                        <div class="p-4 hover:bg-[#1A1B21] transition-colors flex items-center gap-4 group">
                            <div class="w-10 h-10 rounded-full border border-[#23242A] bg-[#050505] flex items-center justify-center flex-shrink-0 group-hover:border-indigo-500/30 transition-colors">
                                <div class="w-2.5 h-2.5 rounded-full {{ $task->status === 'completed' ? 'bg-green-500 box-shadow-green' : ($task->status === 'pending' ? 'bg-gray-500' : 'bg-indigo-500 box-shadow-indigo') }}"></div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-medium text-sm text-gray-200 truncate group-hover:text-white">{{ $task->title }}</h4>
                                <span class="text-xs text-gray-500">{{ $task->internalProject ? $task->internalProject->name : 'General' }}</span>
                            </div>
                            <div class="flex-shrink-0 text-right">
                                <span class="text-xs font-mono text-gray-500">{{ $task->created_at->format('H:i') }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            No recent activity.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar Widgets -->
        <div class="space-y-6">
            <!-- Upcoming Deadlines -->
            <div class="premium-card p-6">
                <h3 class="font-bold text-lg mb-6">Deadlines</h3>
                <div class="space-y-4">
                     @forelse($upcomingTasks as $task)
                        <div class="flex items-center gap-4 p-3 rounded-xl bg-[#1A1B21] border border-[#23242A]">
                            <div class="flex-shrink-0 text-center px-2">
                                <span class="block text-xs text-red-400 font-bold uppercase">{{ $task->due_at->format('M') }}</span>
                                <span class="block text-xl font-bold text-white">{{ $task->due_at->format('d') }}</span>
                            </div>
                            <div class="h-8 w-[1px] bg-[#23242A]"></div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-medium text-white truncate">{{ $task->title }}</h4>
                                <p class="text-xs text-gray-500">{{ $task->due_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-sm text-gray-500 italic text-center py-4">No deadlines coming up.</div>
                    @endforelse
                </div>
            </div>

            <!-- Quick Action Promo -->
            <div class="premium-card p-6 bg-gradient-to-br from-indigo-900/20 to-purple-900/20 border-indigo-500/20">
                <h3 class="font-bold text-lg mb-2">Liquid Focus Mode</h3>
                <p class="text-sm text-gray-400 mb-4">Minimize distractions and boost your productivity session.</p>
                <div class="relative w-full h-2 bg-[#1A1B21] rounded-full mb-4">
                    <div class="absolute left-0 top-0 h-full w-[0%] bg-indigo-500 rounded-full animate-pulse"></div>
                </div>
                <a href="{{ route('dashboard.focus') }}" class="block w-full text-center py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl font-semibold text-sm transition-colors shadow-lg shadow-indigo-600/20">
                    Start Session
                </a>
            </div>
            <!-- Resume Manager -->
            <livewire:dashboard.resume-manager />
        </div>
    </div>
</div>

<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent">Project Planner</h1>
            <p class="text-gray-500">Track your internal projects and consistency.</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2 px-4 py-2 bg-[#1A1B21] rounded-xl border border-[#23242A]">
                <span class="text-xs font-bold text-gray-500 uppercase">Current Streak</span>
                <span class="text-xl font-bold text-orange-400">🔥 {{ $currentStreak }} days</span>
            </div>
            <button wire:click="$set('showNewProjectModal', true)" class="btn-premium px-6 py-2.5 text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>New Project</span>
            </button>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Activity Heatmap (Last 30 Days) -->
    <div class="premium-card p-6">
        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-6">Consistency Map (Last 30 Days)</h3>
        <div class="flex items-end gap-1 overflow-x-auto custom-scrollbar pb-2">
            @for ($i = 29; $i >= 0; $i--)
                @php
                    $date = now()->subDays($i)->format('Y-m-d');
                    $metric = $metrics->firstWhere('date', $date);
                    $intensity = 0;
                    if ($metric) {
                        if ($metric->tasks_completed > 0) $intensity = $metric->tasks_completed >= 5 ? 4 : ($metric->tasks_completed >= 3 ? 3 : 2);
                        elseif ($metric->focus_time > 0) $intensity = 1;
                    }
                    $color = match($intensity) {
                        4 => 'bg-green-500',
                        3 => 'bg-green-600',
                        2 => 'bg-green-800',
                        1 => 'bg-green-900/50',
                        0 => 'bg-[#1A1B21]'
                    };
                @endphp
                <div class="flex flex-col items-center gap-2 group cursor-default">
                    <div class="w-8 h-8 rounded-lg {{ $color }} border border-[#23242A] transition-all hover:scale-110 relative">
                        <!-- Tooltip -->
                        <div class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 w-max px-2 py-1 bg-black border border-[#23242A] text-[10px] rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-10 select-none">
                            {{ $date }}<br>
                            {{ $metric ? $metric->tasks_completed . ' tasks' : 'No activity' }}
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>

    <!-- Active Projects Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($projects as $project)
            <div class="premium-card p-6 group hover:border-indigo-500/30 transition-colors">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="font-bold text-lg text-white group-hover:text-indigo-400 transition-colors">{{ $project->title }}</h3>
                    <div class="px-2 py-1 rounded bg-[#1A1B21] border border-[#23242A] text-xs text-gray-400">
                        {{ $project->status }}
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Progress</span>
                        <span class="text-white font-mono">{{ $project->calculated_progress }}%</span>
                    </div>
                    <!-- Progress Bar -->
                    <div class="h-2 bg-[#1A1B21] rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-600 transition-all duration-1000" 
                             style="width: {{ $project->calculated_progress }}%"></div>
                    </div>
                    
                    <div class="flex justify-between items-center text-xs text-gray-500 mt-4 pt-4 border-t border-[#23242A]">
                        <span>{{ $project->tasks_count ?? 0 }} Tasks</span>
                        <span>Started {{ $project->created_at->format('M d') }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center rounded-3xl border-2 border-dashed border-[#23242A] bg-[#1A1B21]/20">
                <h3 class="text-xl font-bold text-gray-300 mb-2">No Projects Yet</h3>
                <p class="text-gray-500 mb-6">Map out your goals and start tracking.</p>
                <button wire:click="$set('showNewProjectModal', true)" class="px-6 py-2 rounded-xl bg-[#23242A] hover:bg-[#2A2B32] text-white text-sm font-bold transition-colors">
                    Create First Project
                </button>
            </div>
        @endforelse
    </div>

    <!-- New Project Modal -->
    <div x-show="$wire.showNewProjectModal" 
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm"
         style="display: none;"
         x-transition.opacity>
        <div class="bg-[#0F1014] border border-[#23242A] rounded-2xl w-full max-w-md p-6 relative shadow-2xl" @click.away="$wire.showNewProjectModal = false">
            <h3 class="text-xl font-bold mb-6">Create New Project</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Project Title</label>
                    <input type="text" wire:model="newProjectTitle" 
                           class="w-full bg-[#1A1B21] border border-[#23242A] rounded-xl px-4 py-3 text-white focus:border-indigo-500 focus:outline-none"
                           placeholder="e.g. Learn Rust, Build SaaS, Fitness Goal">
                    @error('newProjectTitle') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <button wire:click="$set('showNewProjectModal', false)" class="px-4 py-2 text-gray-400 hover:text-white transition-colors">Cancel</button>
                <button wire:click="createProject" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl font-bold transition-colors">Create Project</button>
            </div>
        </div>
    </div>
</div>

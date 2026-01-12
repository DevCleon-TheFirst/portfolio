<div class="h-[calc(100vh-8rem)] flex gap-8">
    <!-- Main Timer Area -->
    <div class="flex-1 flex flex-col items-center justify-start pt-12 relative">
        <!-- Background Glow -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-indigo-600/10 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="relative z-10 w-full max-w-2xl text-center space-y-12" 
             x-data="{ 
                timeLeft: @entangle('timeLeft'), 
                isActive: @entangle('isActive'),
                mode: @entangle('mode'),
                totalTime: @entangle('totalTime'),
                customMinutes: 25,
                interval: null,
                soundEnabled: true,
                audio: new Audio('/audio/alarm.mp3'),
                init() {
                    // Preload audio
                    this.audio.load();
                },
                toggleSound() {
                    this.soundEnabled = !this.soundEnabled;
                    if(this.soundEnabled) {
                        // Attempt to unlock audio context on user interaction
                        this.audio.play().then(() => {
                            this.audio.pause();
                            this.audio.currentTime = 0;
                        }).catch(e => {});
                    }
                },
                start() {
                    if (this.interval) clearInterval(this.interval);
                    this.interval = setInterval(() => {
                        if (this.isActive && this.timeLeft > 0) {
                            this.timeLeft--;
                        } else if (this.timeLeft === 0 && this.isActive) {
                            this.isActive = false;
                            clearInterval(this.interval);
                            $wire.dispatch('timer-finished');
                            if(this.soundEnabled) {
                                this.audio.currentTime = 0;
                                this.audio.play().catch(e => console.log('Audio error', e));
                            }
                        }
                    }, 1000);
                },
                pause() {
                    this.isActive = false;
                    clearInterval(this.interval);
                },
                formatTime(seconds) {
                    const m = Math.floor(seconds / 60);
                    const s = seconds % 60;
                    return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
                },
                get progress() {
                    return ((this.totalTime - this.timeLeft) / this.totalTime) * 100;
                },
                setCustom() {
                   if (this.customMinutes > 0) {
                       $wire.setCustomTime(this.customMinutes);
                   }
                }
             }"
             x-init="init(); $watch('isActive', value => value ? start() : pause())"
             >
            
            <!-- Mode Switcher -->
            <div class="flex flex-col items-center gap-4">
                <div class="flex flex-wrap justify-center gap-2 bg-[#0F1014] p-1.5 rounded-2xl border border-[#23242A]">
                    <button wire:click="setMode('focus')" 
                            class="px-5 py-2 rounded-xl text-sm font-bold transition-all duration-300 border"
                            :class="mode === 'focus' ? 'bg-[#1A1B21] text-white border-indigo-500/30 shadow-lg shadow-indigo-500/10' : 'bg-transparent text-gray-300 border-transparent hover:bg-[#1A1B21] hover:text-white'">
                        Focus
                    </button>
                    <button wire:click="setMode('break')" 
                            class="px-5 py-2 rounded-xl text-sm font-bold transition-all duration-300 border"
                            :class="mode === 'break' ? 'bg-[#1A1B21] text-white border-purple-500/30 shadow-lg shadow-purple-500/10' : 'bg-transparent text-gray-300 border-transparent hover:bg-[#1A1B21] hover:text-white'">
                        Short Break
                    </button>
                </div>

                <!-- Custom Duration (Always Visible) -->
                <div class="flex items-center gap-3 bg-[#1A1B21] p-2 rounded-xl border border-[#23242A] mt-2">
                    <span class="text-xs font-semibold text-gray-400 pl-2">Custom (mins):</span>
                    <input type="number" x-model="customMinutes" min="1" max="180" 
                           class="w-20 bg-[#0F1014] border border-[#23242A] rounded-lg px-3 py-1.5 text-center text-white focus:outline-none focus:border-indigo-500 text-sm font-bold"
                           @keydown.enter="setCustom()">
                    <button @click="setCustom()" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg transition-colors text-xs font-bold uppercase tracking-wider">
                        Set
                    </button>
                </div>
            </div>

            <!-- Timer Circle -->
            <div class="relative w-80 h-80 mx-auto">
                <!-- SVG Circle -->
                <svg class="w-full h-full transform -rotate-90">
                    <!-- Track -->
                    <circle cx="160" cy="160" r="140" stroke="#1A1B21" stroke-width="12" fill="none" />
                    <!-- Progress -->
                    <circle cx="160" cy="160" r="140" stroke="currentColor" stroke-width="12" fill="none"
                            :class="mode === 'focus' ? 'text-indigo-500' : 'text-purple-500'"
                            stroke-dasharray="879.6"
                            :stroke-dashoffset="879.6 - (879.6 * progress / 100)"
                            class="transition-[stroke-dashoffset] duration-1000 ease-linear shadow-[0_0_20px_currentColor]"
                            stroke-linecap="round" />
                </svg>
                
                <!-- Time Display -->
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-7xl font-bold tracking-tighter tabular-nums" x-text="formatTime(timeLeft)">
                        25:00
                    </span>
                    <p class="text-gray-500 mt-2 font-medium uppercase tracking-widest text-xs" x-text="isActive ? (mode === 'focus' ? 'Focusing...' : 'Resting...') : 'Ready'"></p>
                </div>
            </div>

            <!-- Task Selector (Focus or Custom Mode) -->
            <div x-show="mode === 'focus' || mode === 'custom'" x-transition class="max-w-md mx-auto relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
                <div class="relative">
                    <select wire:model.live="selectedTaskId" :disabled="isActive"
                            class="w-full bg-[#0F1014] border border-[#23242A] rounded-xl px-4 py-4 text-white focus:outline-none focus:border-indigo-500/50 appearance-none text-center font-medium disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer">
                        <option value="">Select a Task to Focus On</option>
                        @foreach($tasks as $task)
                            <option value="{{ $task->id }}">{{ $task->title }}</option>
                        @endforeach
                    </select>
                     <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
                @error('task') <p class="text-red-500 text-sm mt-2">{{ $message }}</p> @enderror
            </div>

            <!-- Controls -->
            <div class="flex items-center justify-center gap-6">
                <button wire:click="resetTimer" 
                        class="p-4 rounded-full text-gray-400 hover:text-white hover:bg-[#1A1B21] transition-all"
                        title="Reset">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </button>

                <button x-on:click="if(isActive) { $wire.pauseTimer() } else { $wire.startTimer() }"
                        class="btn-premium w-20 h-20 rounded-full flex items-center justify-center shadow-2xl shadow-indigo-500/30 hover:shadow-indigo-500/50 hover:scale-105 active:scale-95 transition-all">
                    <svg x-show="!isActive" class="w-8 h-8 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    <svg x-show="isActive" class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                </button>

                <button @click="toggleSound()" 
                        class="p-4 rounded-full transition-all"
                        :class="soundEnabled ? 'text-indigo-400 bg-[#1A1B21]' : 'text-gray-400 hover:text-white hover:bg-[#1A1B21]'"
                        :title="soundEnabled ? 'Mute Sound' : 'Unmute Sound'">
                    <!-- Sound On Icon -->
                    <svg x-show="soundEnabled" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/></svg>
                    <!-- Sound Off Icon -->
                    <svg x-show="!soundEnabled" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z m15.536-6.536L5.586 15"/></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Right Sidebar (Stats & History) -->
    <div class="w-80 border-l border-[#23242A] bg-[#0A0A0A] hidden xl:flex flex-col">
        <!-- Daily Goal -->
        <div class="p-6 border-b border-[#23242A]">
            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Daily Progress</h3>
            <div class="flex items-end justify-between mb-2">
                <span class="text-3xl font-bold text-white">{{ floor($dailyMinutes / 60) }}h {{ $dailyMinutes % 60 }}m</span>
                <span class="text-sm text-gray-500 mb-1">/ 4h Goal</span>
            </div>
            <div class="h-2 bg-[#1A1B21] rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full" style="width: {{ min(100, ($dailyMinutes / 240) * 100) }}%"></div>
            </div>
        </div>

        <!-- History -->
        <div class="flex-1 overflow-y-auto p-6 custom-scrollbar">
            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Recent Sessions</h3>
            <div class="space-y-4">
                @forelse($recentSessions as $session)
                    <div class="flex items-start gap-4 group">
                        <div class="mt-1 w-2 h-2 rounded-full {{ $session->completed ? 'bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.5)]' : 'bg-red-500' }}"></div>
                        <div>
                            <h4 class="text-sm font-semibold text-gray-200 group-hover:text-indigo-400 transition-colors">{{ $session->task->title }}</h4>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-xs text-gray-500">{{ $session->duration }} mins</span>
                                <span class="text-xs text-gray-600">•</span>
                                <span class="text-xs text-gray-500">{{ $session->created_at->format('H:i') }}</span>
                            </div>
                            @if($session->task->internalProject)
                                <span class="inline-block mt-2 text-[10px] items-center px-1.5 py-0.5 rounded border border-[#23242A] bg-[#1A1B21] text-gray-400">
                                    {{ $session->task->internalProject->name }}
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-sm text-gray-500">No sessions yet today.</p>
                        <p class="text-xs text-indigo-400 mt-1">Start digging deep!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

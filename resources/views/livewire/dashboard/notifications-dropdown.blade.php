<div class="relative" x-data="{ open: false }">
    <button @click="open = !open; if(open) $wire.markAsRead()" @click.away="open = false" class="relative text-gray-400 hover:text-white transition-colors">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
        @if($unreadCount > 0)
            <div class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full border-2 border-[#050505] animate-pulse"></div>
        @endif
    </button>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2"
         class="absolute right-0 mt-2 w-80 bg-[#0F1014] border border-[#23242A] rounded-xl shadow-2xl z-50 overflow-hidden"
         style="display: none;">
        
        <div class="p-4 border-b border-[#23242A] flex justify-between items-center">
            <h3 class="text-sm font-bold text-white">System Activity</h3>
            <span class="text-xs text-gray-500">{{ $unreadCount }} new</span>
        </div>

        <div class="max-h-[400px] overflow-y-auto custom-scrollbar">
            @forelse($logs as $log)
                <div class="p-4 border-b border-[#23242A] hover:bg-[#1A1B21] transition-colors cursor-default group">
                    <div class="flex gap-3">
                        <div class="mt-1">
                            @if($log->color === 'red')
                                <div class="w-2 h-2 rounded-full bg-red-500 shadow-[0_0_8px_rgba(239,68,68,0.5)]"></div>
                            @elseif($log->color === 'green')
                                <div class="w-2 h-2 rounded-full bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.5)]"></div>
                            @elseif($log->color === 'purple')
                                <div class="w-2 h-2 rounded-full bg-purple-500 shadow-[0_0_8px_rgba(168,85,247,0.5)]"></div>
                            @else
                                <div class="w-2 h-2 rounded-full bg-indigo-500 shadow-[0_0_8px_rgba(99,102,241,0.5)]"></div>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-200 group-hover:text-white transition-colors">{{ $log->action }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $log->description }}</p>
                            <p class="text-[10px] text-gray-600 mt-2">{{ $log->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center">
                    <p class="text-sm text-gray-500">No activity yet.</p>
                </div>
            @endforelse
        </div>
        
        <div class="p-2 border-t border-[#23242A] bg-[#0A0A0A]">
            <button class="w-full py-2 text-xs text-gray-400 hover:text-white transition-colors">View All Logs</button>
        </div>
    </div>
</div>

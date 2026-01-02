<div class="h-[calc(100vh-8rem)] flex flex-col lg:flex-row gap-6 overflow-hidden">
    
    <!-- Left Column: Message List -->
    <div class="w-full lg:w-1/3 flex flex-col bg-[#0F1014] border border-[#23242A] rounded-[20px] overflow-hidden" 
         :class="$wire.selectedMessageId ? 'hidden lg:flex' : 'flex'">
        
        <!-- Header / Search -->
        <div class="p-4 border-b border-[#23242A] space-y-4 bg-[#0A0A0A]">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-white">Inbox <span class="text-xs ml-1 text-gray-500 font-normal">({{ $unreadCount }} new)</span></h2>
                <select wire:model.live="filter" class="bg-[#1A1B21] border border-[#23242A] text-xs rounded-lg px-2 py-1 text-gray-300 focus:outline-none focus:border-indigo-500">
                    <option value="all">All Messages</option>
                    <option value="unread">Unread Only</option>
                    <option value="read">Read Only</option>
                </select>
            </div>
            
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search sender..." 
                       class="w-full pl-9 pr-4 py-2 bg-[#1A1B21] border border-[#23242A] rounded-xl text-sm text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500 transition-colors">
            </div>
        </div>

        <!-- List -->
        <div class="flex-1 overflow-y-auto custom-scrollbar p-2 space-y-2">
            @forelse($messages as $msg)
                <button wire:click="selectMessage({{ $msg->id }})" 
                        class="w-full text-left p-4 rounded-xl border transition-all duration-200 group relative
                        {{ $selectedMessageId === $msg->id ? 'bg-[#1A1B21] border-indigo-500/50 shadow-lg shadow-indigo-500/5' : 'bg-transparent border-transparent hover:bg-[#1A1B21] hover:border-[#23242A]' }}">
                    
                    @if(!$msg->is_read)
                        <div class="absolute right-4 top-4 w-2 h-2 rounded-full bg-indigo-500 shadow-[0_0_8px_rgba(99,102,241,0.6)]"></div>
                    @endif

                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-gray-800 to-gray-700 flex items-center justify-center text-xs font-bold text-gray-300 border border-[#23242A]">
                            {{ substr($msg->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-semibold {{ $msg->is_read ? 'text-gray-300' : 'text-white' }} truncate">{{ $msg->name }}</h4>
                            <p class="text-[10px] text-gray-500">{{ $msg->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    
                    <h5 class="text-xs font-medium text-gray-400 mb-1 truncate pr-4">{{ $msg->subject }}</h5>
                    <p class="text-xs text-gray-600 line-clamp-2">{{ $msg->message }}</p>
                </button>
            @empty
                <div class="text-center py-10 text-gray-500 text-sm">
                    No messages found.
                </div>
            @endforelse
            
            <div class="p-2">
                {{ $messages->links() }}
            </div>
        </div>
    </div>

    <!-- Right Column: Detail View -->
    <div class="flex-1 bg-[#0F1014] border border-[#23242A] rounded-[20px] overflow-hidden flex flex-col relative"
         :class="$wire.selectedMessageId ? 'flex fixed inset-0 z-50 lg:static lg:z-auto' : 'hidden lg:flex'">
        
        <!-- Mobile Back Button -->
        <div class="lg:hidden p-4 border-b border-[#23242A] bg-[#0A0A0A] flex items-center gap-3">
            <button wire:click="$set('selectedMessageId', null)" class="text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <span class="font-bold text-white">Back to Inbox</span>
        </div>

        @if($selectedMessage)
            <div class="p-6 lg:p-10 flex-1 overflow-y-auto">
                <!-- Message Header -->
                <div class="flex justify-between items-start mb-8 pb-8 border-b border-[#23242A]">
                    <div class="flex gap-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-indigo-500/20">
                            {{ substr($selectedMessage->name, 0, 1) }}
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-white mb-1">{{ $selectedMessage->subject }}</h1>
                            <div class="flex items-center gap-2 text-sm text-gray-400">
                                <span class="font-medium text-gray-300">{{ $selectedMessage->name }}</span>
                                <span>&lt;{{ $selectedMessage->email }}&gt;</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <button wire:click="markAsUnread({{ $selectedMessage->id }})" title="Mark as Unread" class="p-2 text-gray-500 hover:text-white transition-colors bg-[#1A1B21] rounded-lg border border-[#23242A]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </button>
                        <button wire:click="delete({{ $selectedMessage->id }})" title="Delete" class="p-2 text-gray-500 hover:text-red-400 transition-colors bg-[#1A1B21] rounded-lg border border-[#23242A] hover:border-red-500/50">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Content -->
                <div class="prose prose-invert max-w-none text-gray-300">
                    {!! nl2br(e($selectedMessage->message)) !!}
                </div>

                 <!-- Meta -->
                <div class="mt-8 pt-6 border-t border-[#23242A] flex justify-between text-xs text-gray-600">
                     <span>Sent {{ $selectedMessage->created_at->format('F j, Y, g:i a') }}</span>
                     <span>IP: {{ $selectedMessage->ip_address ?? 'Unknown' }}</span>
                </div>
            </div>

            <!-- Footer Reply Action -->
            <div class="p-6 bg-[#0A0A0A] border-t border-[#23242A] flex justify-end">
                <a href="mailto:{{ $selectedMessage->email }}?subject=Re: {{ $selectedMessage->subject }}" 
                   class="btn-premium px-6 py-2.5 flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                    Reply via Email
                </a>
            </div>

        @else
            <!-- Non Selected State -->
            <div class="flex-1 flex flex-col items-center justify-center text-gray-500 p-8 text-center opacity-50">
                <div class="w-24 h-24 rounded-full bg-[#1A1B21] flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                </div>
                <h3 class="text-lg font-medium text-gray-400">Select a message to read</h3>
                <p class="text-sm mt-2 max-w-xs">Messages from your contact form will appear here. Click on any item on the left to view details.</p>
            </div>
        @endif
    </div>
</div>

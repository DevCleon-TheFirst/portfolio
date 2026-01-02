<div class="space-y-8">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent">Contact Messages</h1>
            <p class="text-gray-500">Manage inquiries from your portfolio</p>
        </div>
        @if($unreadCount > 0)
            <div class="px-4 py-2 bg-blue-600/20 border border-blue-500/30 rounded-lg">
                <span class="text-blue-400 font-bold">{{ $unreadCount }} Unread</span>
            </div>
        @endif
    </div>

    @if (session()->has('success'))
        <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <!-- Messages List -->
    <div class="premium-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#1A1B21] border-b border-[#23242A]">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase">Name</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase">Subject</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase">Date</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#23242A]">
                    @forelse($messages as $message)
                        <tr class="hover:bg-[#1A1B21] transition-colors {{ !$message->is_read ? 'bg-blue-600/5' : '' }}">
                            <td class="px-6 py-4">
                                @if($message->is_read)
                                    <span class="px-2 py-1 bg-gray-600/20 text-gray-400 rounded text-xs">Read</span>
                                @else
                                    <span class="px-2 py-1 bg-blue-600/20 text-blue-400 rounded text-xs font-bold">New</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-medium">{{ $message->name }}</td>
                            <td class="px-6 py-4 text-gray-400">{{ $message->email }}</td>
                            <td class="px-6 py-4 text-gray-400">{{ $message->subject ?: 'No subject' }}</td>
                            <td class="px-6 py-4 text-gray-400 text-sm">{{ $message->created_at->diffForHumans() }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button wire:click="viewMessage({{ $message->id }})" 
                                    class="px-3 py-1 bg-indigo-600/20 text-indigo-400 rounded hover:bg-indigo-600/30 transition text-sm">
                                    View
                                </button>
                                <button wire:click="deleteMessage({{ $message->id }})" 
                                    wire:confirm="Are you sure you want to delete this message?"
                                    class="px-3 py-1 bg-red-600/20 text-red-400 rounded hover:bg-red-600/30 transition text-sm">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                No messages yet. They'll appear here when someone contacts you.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-[#23242A]">
            {{ $messages->links() }}
        </div>
    </div>

    <!-- View Message Modal -->
    @if($showModal && $selectedMessage)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm" wire:click="closeModal">
            <div class="bg-[#0F1014] border border-[#23242A] rounded-2xl w-full max-w-2xl p-8 relative shadow-2xl" wire:click.stop>
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h3 class="text-2xl font-bold mb-2">{{ $selectedMessage->subject ?: 'Message from ' . $selectedMessage->name }}</h3>
                        <p class="text-gray-400 text-sm">{{ $selectedMessage->created_at->format('M d, Y \a\t h:i A') }}</p>
                    </div>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <div class="space-y-4 mb-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase mb-1">From</p>
                            <p class="font-semibold">{{ $selectedMessage->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase mb-1">Email</p>
                            <a href="mailto:{{ $selectedMessage->email }}" class="text-blue-400 hover:text-blue-300">
                                {{ $selectedMessage->email }}
                            </a>
                        </div>
                    </div>
                    
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase mb-2">Message</p>
                        <div class="bg-[#1A1B21] border border-[#23242A] rounded-xl p-4">
                            <p class="text-gray-300 whitespace-pre-wrap">{{ $selectedMessage->message }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="flex gap-3">
                    <a href="mailto:{{ $selectedMessage->email }}?subject=Re: {{ $selectedMessage->subject }}" 
                        class="flex-1 px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl font-bold text-center transition">
                        Reply via Email
                    </a>
                    <button wire:click="closeModal" 
                        class="px-6 py-3 bg-[#1A1B21] hover:bg-[#23242A] text-white rounded-xl font-bold transition">
                        Close
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

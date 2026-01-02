<div class="space-y-8">
    <!-- Header -->
    <div class="flex justify-between items-center bg-[#0F1014] p-6 rounded-[20px] border border-[#23242A]">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white">Timeline Manager</h1>
            <p class="text-gray-400 text-sm mt-1">Visualize your professional journey</p>
        </div>
        <button wire:click="create" class="btn-premium px-6 py-2.5 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>New Event</span>
        </button>
    </div>

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 px-6 py-4 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('message') }}
        </div>
    @endif

    <!-- Timeline View -->
    <div class="relative pl-8 border-l border-[#23242A] space-y-8 ml-4">
        @forelse($events as $event)
            <div class="relative group">
                <!-- Dot -->
                <div class="absolute -left-[41px] top-6 w-5 h-5 rounded-full bg-[#050505] border-2 border-indigo-500/50 group-hover:border-indigo-400 group-hover:shadow-[0_0_10px_rgba(99,102,241,0.5)] transition-all z-10"></div>
                
                <div class="premium-card p-6 relative group hover:border-[#373842] transition-colors">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 bg-indigo-500/10 text-indigo-400 text-xs font-bold uppercase tracking-wider rounded border border-indigo-500/20 shadow-lg shadow-indigo-500/5">
                                {{ $event->date->format('M Y') }}
                            </span>
                            @if($event->event_type)
                                <span class="px-3 py-1 text-xs text-gray-500 uppercase tracking-wider border border-[#23242A] rounded bg-[#0A0A0A]">
                                    {{ $event->event_type }}
                                </span>
                            @endif
                        </div>
                         <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button wire:click="edit({{ $event->id }})" class="p-1.5 text-gray-400 hover:text-white hover:bg-[#1A1B21] rounded transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            <button wire:click="delete({{ $event->id }})" onclick="return confirm('Delete this event?')" class="p-1.5 text-gray-400 hover:text-red-400 hover:bg-[#1A1B21] rounded transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mb-3">
                        @if($event->icon)
                             <span class="text-2xl bg-[#1A1B21] w-10 h-10 flex items-center justify-center rounded-lg border border-[#23242A]">{{ $event->icon }}</span>
                        @endif
                        <h3 class="text-xl font-bold text-white group-hover:text-indigo-400 transition-colors">{{ $event->title }}</h3>
                    </div>

                    <p class="text-gray-400 text-sm leading-relaxed max-w-3xl">
                        {{ $event->description }}
                    </p>
                </div>
            </div>
        @empty
            <div class="py-16 flex flex-col items-center justify-center text-center">
                <div class="w-16 h-16 bg-[#1A1B21] rounded-full flex items-center justify-center mb-4 text-gray-600 border border-[#23242A]">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-gray-400 mb-1 font-medium">Your timeline is empty.</p>
                <button wire:click="create" class="mt-4 text-sm text-indigo-400 hover:text-indigo-300">Add First Milestone →</button>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $events->links() }}
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-[100] p-4" wire:click.self="closeModal">
             <div class="bg-[#0F1014] border border-[#23242A] rounded-2xl w-full max-w-lg shadow-2xl animate-in fade-in zoom-in duration-200">
                <div class="flex justify-between items-center p-6 border-b border-[#23242A] bg-[#0A0A0A]">
                    <h2 class="text-xl font-bold text-white">{{ $editMode ? 'Edit Event' : 'New Event' }}</h2>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="p-8">
                    <form wire:submit.prevent="save" class="space-y-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Event Title</label>
                            <input type="text" wire:model="title" class="w-full bg-[#1A1B21] border border-[#23242A] rounded-xl px-4 py-3 text-white focus:border-indigo-500 focus:outline-none transition-colors" placeholder="e.g. Senior Developer Promotion">
                            @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Date</label>
                                <input type="date" wire:model="date" class="w-full bg-[#1A1B21] border border-[#23242A] rounded-xl px-4 py-3 text-gray-300 focus:border-indigo-500 focus:outline-none transition-colors">
                                @error('date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Type</label>
                                <select wire:model="event_type" class="w-full bg-[#1A1B21] border border-[#23242A] rounded-xl px-4 py-3 text-gray-300 focus:border-indigo-500 focus:outline-none transition-colors text-sm">
                                    <option value="work">Work Experience</option>
                                    <option value="education">Education</option>
                                    <option value="certification">Certification</option>
                                    <option value="project">Project Launch</option>
                                    <option value="milestone">Life Milestone</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Description</label>
                            <textarea wire:model="description" rows="3" class="w-full bg-[#1A1B21] border border-[#23242A] rounded-xl px-4 py-3 text-white focus:border-indigo-500 focus:outline-none transition-colors" placeholder="Details..."></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                 <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Icon (Emoji)</label>
                                 <input type="text" wire:model="icon" class="w-full bg-[#1A1B21] border border-[#23242A] rounded-xl px-4 py-3 text-white focus:border-indigo-500 focus:outline-none transition-colors text-center" placeholder="🎓">
                            </div>
                            <div>
                                 <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Sort Order</label>
                                 <input type="number" wire:model="order" class="w-full bg-[#1A1B21] border border-[#23242A] rounded-xl px-4 py-3 text-white focus:border-indigo-500 focus:outline-none transition-colors text-center">
                            </div>
                        </div>

                        <div class="pt-6 flex justify-end gap-3">
                            <button type="button" wire:click="closeModal" class="px-6 py-2.5 rounded-xl border border-[#23242A] text-gray-400 hover:text-white hover:bg-[#1A1B21] transition-colors font-medium text-sm">Cancel</button>
                            <button type="submit" class="btn-premium px-8 py-2.5 text-sm">{{ $editMode ? 'Update Event' : 'Add Event' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

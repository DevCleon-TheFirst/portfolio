<div class="space-y-8">
    <!-- Header -->
    <div class="flex justify-between items-center bg-[#0F1014] p-6 rounded-[20px] border border-[#23242A]">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white">Skills Manager</h1>
            <p class="text-gray-400 text-sm mt-1">Quantify and showcase your technical expertise</p>
        </div>
        <button wire:click="create" class="btn-premium px-6 py-2.5 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>New Skill</span>
        </button>
    </div>

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 px-6 py-4 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('message') }}
        </div>
    @endif

    <!-- Skills Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($skills as $skill)
            <div class="premium-card p-6 group hover:border-indigo-500/30 transition-colors relative overflow-hidden">
                <!-- Background Glow -->
                <div class="absolute top-0 right-0 w-24 h-24 bg-indigo-500/5 rounded-full blur-2xl -mr-8 -mt-8 group-hover:bg-indigo-500/10 transition-colors"></div>

                <div class="flex items-start justify-between mb-6 relative z-10">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-[#1A1B21] border border-[#23242A] flex items-center justify-center text-2xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                             {{ $skill->icon ?: '⚡' }}
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-white group-hover:text-indigo-400 transition-colors">{{ $skill->name }}</h3>
                            <span class="text-[10px] uppercase tracking-wider font-bold text-gray-500 border border-[#23242A] px-2 py-0.5 rounded-full bg-[#0A0A0A]">{{ $skill->category }}</span>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button wire:click="edit({{ $skill->id }})" class="p-1.5 text-gray-500 hover:text-white hover:bg-[#1A1B21] rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </button>
                        <button wire:click="delete({{ $skill->id }})" onclick="return confirm('Delete this skill?')" class="p-1.5 text-gray-500 hover:text-red-400 hover:bg-[#1A1B21] rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                </div>

                <div class="space-y-2 relative z-10">
                    <div class="flex justify-between text-xs font-semibold tracking-wide">
                        <span class="text-gray-400">Proficiency</span>
                        <span class="text-indigo-400">{{ $skill->proficiency }}%</span>
                    </div>
                    <div class="w-full bg-[#1A1B21] rounded-full h-2 overflow-hidden border border-[#23242A]">
                        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 h-2 rounded-full relative" style="width: {{ $skill->proficiency }}%">
                             <div class="absolute inset-0 bg-white/20"></div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center border border-[#23242A] border-dashed rounded-2xl bg-[#0F1014]">
                <p class="text-xl text-gray-400 font-medium">No skills found</p>
                <p class="text-sm text-gray-600 mt-2">Add your technical skills to build your profile.</p>
                <button wire:click="create" class="mt-4 btn-premium px-6 py-2 text-sm">Add First Skill</button>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $skills->links() }}
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-[100] p-4" wire:click.self="closeModal">
             <div class="bg-[#0F1014] border border-[#23242A] rounded-2xl w-full max-w-lg shadow-2xl animate-in fade-in zoom-in duration-200">
                <div class="flex justify-between items-center p-6 border-b border-[#23242A] bg-[#0A0A0A]">
                    <h2 class="text-xl font-bold text-white">{{ $editMode ? 'Edit Skill' : 'New Skill' }}</h2>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="p-8">
                    <form wire:submit.prevent="save" class="space-y-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Skill Name</label>
                            <input type="text" wire:model="name" class="w-full bg-[#1A1B21] border border-[#23242A] rounded-xl px-4 py-3 text-white focus:border-indigo-500 focus:outline-none transition-colors" placeholder="e.g. Laravel">
                            @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Category</label>
                            <select wire:model="category" class="w-full bg-[#1A1B21] border border-[#23242A] rounded-xl px-4 py-3 text-white focus:border-indigo-500 focus:outline-none text-sm">
                                <option value="frontend">Frontend Development</option>
                                <option value="backend">Backend Development</option>
                                <option value="mobile">Mobile Development</option>
                                <option value="devops">DevOps & Cloud</option>
                                <option value="tools">Tools & Software</option>
                                <option value="soft">Soft Skills</option>
                            </select>
                            @error('category') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <div class="flex justify-between mb-2">
                                 <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Proficiency</label>
                                 <span class="text-xs font-bold text-indigo-400">{{ $proficiency }}%</span>
                            </div>
                            <input type="range" wire:model.live="proficiency" min="0" max="100" class="w-full h-2 bg-[#1A1B21] rounded-lg appearance-none cursor-pointer accent-indigo-500">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Icon (Emoji)</label>
                                <input type="text" wire:model="icon" class="w-full bg-[#1A1B21] border border-[#23242A] rounded-xl px-4 py-3 text-white focus:border-indigo-500 focus:outline-none transition-colors text-center" placeholder="🚀">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Sort Order</label>
                                <input type="number" wire:model="order" class="w-full bg-[#1A1B21] border border-[#23242A] rounded-xl px-4 py-3 text-white focus:border-indigo-500 focus:outline-none transition-colors text-center">
                            </div>
                        </div>

                        <div class="pt-6 flex justify-end gap-3">
                            <button type="button" wire:click="closeModal" class="px-6 py-2.5 rounded-xl border border-[#23242A] text-gray-400 hover:text-white hover:bg-[#1A1B21] transition-colors font-medium text-sm">Cancel</button>
                            <button type="submit" class="btn-premium px-8 py-2.5 text-sm">{{ $editMode ? 'Update Skill' : 'Add Skill' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

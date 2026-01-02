<div class="space-y-8">
    <!-- Header -->
    <div class="flex justify-between items-center bg-[#0F1014] p-6 rounded-[20px] border border-[#23242A]">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white">Project Manager</h1>
            <p class="text-gray-400 text-sm mt-1">Showcase your portfolio with premium presentation</p>
        </div>
        <button wire:click="create" class="btn-premium px-6 py-2.5 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>New Project</span>
        </button>
    </div>

    <!-- Controls -->
    <div class="flex flex-col md:flex-row gap-4">
        <div class="relative flex-1 max-w-md">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" wire:model.live="search" placeholder="Search projects..." 
                class="w-full pl-10 pr-4 py-3 bg-[#0F1014] border border-[#23242A] rounded-xl text-gray-200 placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none transition-all">
        </div>
        <div class="flex gap-2">
            <!-- Filter Pills (Visual Only for now, could be wired up) -->
            <button class="px-4 py-2 rounded-xl bg-[#1A1B21] border border-[#23242A] text-white text-sm font-medium hover:border-indigo-500 transition-colors">All</button>
            <button class="px-4 py-2 rounded-xl bg-[#0F1014] border border-[#23242A] text-gray-400 text-sm font-medium hover:border-indigo-500/50 hover:text-white transition-colors">Web</button>
            <button class="px-4 py-2 rounded-xl bg-[#0F1014] border border-[#23242A] text-gray-400 text-sm font-medium hover:border-indigo-500/50 hover:text-white transition-colors">Mobile</button>
        </div>
    </div>

    <!-- Projects Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($projects as $project)
            <div class="premium-card group relative flex flex-col overflow-hidden h-full">
                <!-- Image & Gradient Overlay -->
                <div class="relative h-48 bg-[#1A1B21] overflow-hidden">
                    @if($project->image_path)
                        <img src="{{ Storage::url($project->image_path) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-[#23242A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0F1014] to-transparent opacity-90"></div>
                    
                    <div class="absolute top-4 left-4">
                        <span class="px-2.5 py-1 bg-black/60 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-wider rounded border border-white/10">
                            {{ $project->category }}
                        </span>
                    </div>

                    <button wire:click="toggleFeatured({{ $project->id }})" class="absolute top-4 right-4 p-2 rounded-full backdrop-blur-md border transition-all {{ $project->is_featured ? 'bg-yellow-500/10 text-yellow-400 border-yellow-500/30' : 'bg-black/40 text-gray-500 border-white/5 hover:text-white' }}">
                        <svg class="w-4 h-4 {{ $project->is_featured ? 'fill-current' : 'fill-none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    </button>
                </div>

                <div class="p-6 flex-1 flex flex-col">
                    <h3 class="text-xl font-bold text-white mb-2 group-hover:text-indigo-400 transition-colors">{{ $project->title }}</h3>
                    <p class="text-gray-400 text-sm mb-4 line-clamp-2 flex-grow">{{ $project->problem }}</p>

                    <div class="flex flex-wrap gap-2 mb-6">
                         @foreach(array_slice($project->tech_stack ?? [], 0, 3) as $tech)
                            <span class="px-2 py-1 bg-[#1A1B21] border border-[#23242A] rounded text-[10px] font-mono text-indigo-300 uppercase tracking-tight">
                                {{ $tech }}
                            </span>
                        @endforeach
                    </div>

                    <div class="pt-4 border-t border-[#23242A] flex justify-between items-center mt-auto">
                         <div class="text-xs text-gray-500 font-mono flex items-center gap-2">
                            <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg> {{ $project->view_count }}</span>
                         </div>
                        <div class="flex gap-2">
                             <button wire:click="edit({{ $project->id }})" class="p-2 text-gray-400 hover:text-white hover:bg-[#1A1B21] rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            <button wire:click="delete({{ $project->id }})" class="p-2 text-gray-400 hover:text-red-400 hover:bg-[#1A1B21] rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 bg-[#0F1014] border border-[#23242A] border-dashed rounded-2xl flex flex-col items-center justify-center text-center">
                 <div class="w-16 h-16 bg-[#1A1B21] rounded-full flex items-center justify-center mb-4 text-gray-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <h3 class="text-lg font-bold text-white">No projects yet</h3>
                <p class="text-gray-500 mt-2 text-sm max-w-sm">Start building your portfolio by adding your first project.</p>
                <button wire:click="create" class="mt-6 btn-premium px-6 py-2 text-sm">Create Project</button>
            </div>
        @endforelse
    </div>
    
    <!-- Modal (Premium Style) -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-[100] p-4" wire:click.self="closeModal">
             <div class="bg-[#0F1014] border border-[#23242A] rounded-2xl w-full max-w-4xl max-h-[90vh] flex flex-col shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
                <div class="flex justify-between items-center p-6 border-b border-[#23242A] bg-[#0A0A0A]">
                    <h2 class="text-xl font-bold text-white">{{ $editMode ? 'Edit Project' : 'New Project' }}</h2>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                
                <div class="p-8 overflow-y-auto flex-1 custom-scrollbar">
                    <form wire:submit.prevent="save" class="space-y-8">
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Project Title</label>
                                    <input type="text" wire:model="title" class="w-full bg-[#1A1B21] border border-[#23242A] rounded-xl px-4 py-3 text-white focus:border-indigo-500 focus:outline-none transition-colors" placeholder="Project Name">
                                    @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Category</label>
                                    <select wire:model="category" class="w-full bg-[#1A1B21] border border-[#23242A] rounded-xl px-4 py-3 text-white focus:border-indigo-500 focus:outline-none transition-colors">
                                        <option value="web">Web Application</option>
                                        <option value="mobile">Mobile App</option>
                                        <option value="desktop">Desktop App</option>
                                        <option value="api">API / Backend</option>
                                    </select>
                                </div>
                                 <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tech Stack</label>
                                    <input type="text" wire:model="tech_stack" class="w-full bg-[#1A1B21] border border-[#23242A] rounded-xl px-4 py-3 text-white focus:border-indigo-500 focus:outline-none transition-colors" placeholder="e.g. Laravel, Vue, AWS">
                                </div>
                            </div>
                            <div class="space-y-6">
                                 <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Cover Image</label>
                                    <div class="relative h-40 bg-[#1A1B21] border-2 border-dashed border-[#23242A] rounded-xl hover:border-gray-600 transition-colors flex flex-col items-center justify-center group cursor-pointer">
                                        <svg class="w-8 h-8 text-gray-600 mb-2 group-hover:text-gray-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span class="text-xs text-gray-500">Upload Cover</span>
                                        <input type="file" wire:model="image" class="absolute inset-0 opacity-0 cursor-pointer">
                                    </div>
                                </div>
                                <div class="bg-[#1A1B21] p-4 rounded-xl border border-[#23242A]">
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="checkbox" wire:model="is_featured" class="form-checkbox h-5 w-5 text-indigo-500 rounded border-gray-600 bg-gray-800 focus:ring-0 focus:ring-offset-0">
                                        <div>
                                            <span class="block text-sm font-bold text-white">Featured Project</span>
                                            <span class="block text-xs text-gray-500">Highlight this on your main portfolio</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                         </div>
                         
                         <div class="space-y-4 pt-6 border-t border-[#23242A]">
                             <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider">Case Study (PSR Method)</h3>
                             <textarea wire:model="problem" rows="2" class="w-full bg-[#1A1B21] border border-[#23242A] rounded-xl px-4 py-3 text-white focus:border-indigo-500 focus:outline-none transition-colors" placeholder="The Problem..."></textarea>
                             <textarea wire:model="solution" rows="2" class="w-full bg-[#1A1B21] border border-[#23242A] rounded-xl px-4 py-3 text-white focus:border-indigo-500 focus:outline-none transition-colors" placeholder="The Solution..."></textarea>
                             <textarea wire:model="result" rows="2" class="w-full bg-[#1A1B21] border border-[#23242A] rounded-xl px-4 py-3 text-white focus:border-indigo-500 focus:outline-none transition-colors" placeholder="The Result..."></textarea>
                         </div>
                    </form>
                </div>
                
                <div class="p-6 border-t border-[#23242A] bg-[#0A0A0A] flex justify-end gap-3">
                    <button wire:click="closeModal" class="px-6 py-2.5 rounded-xl border border-[#23242A] text-gray-400 hover:text-white hover:bg-[#1A1B21] transition-colors font-medium text-sm">Cancel</button>
                    <button wire:click="save" class="btn-premium px-8 py-2.5 text-sm">{{ $editMode ? 'Save Changes' : 'Publish Project' }}</button>
                </div>
             </div>
        </div>
    @endif
</div>

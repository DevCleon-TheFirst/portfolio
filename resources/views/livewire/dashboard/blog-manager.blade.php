<div class="space-y-8">
    <!-- Header -->
    <div class="flex justify-between items-center bg-[#0F1014] p-6 rounded-[20px] border border-[#23242A]">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white">Blog Manager</h1>
            <p class="text-gray-400 text-sm mt-1">Create and manage your content strategy</p>
        </div>
        <button wire:click="create" class="btn-premium px-6 py-2.5 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>New Post</span>
        </button>
    </div>

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 px-6 py-4 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('message') }}
        </div>
    @endif

    <!-- Content Split -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Posts List -->
        <div class="lg:col-span-2 space-y-4">
             <!-- Search & Filter -->
            <div class="flex gap-4">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" wire:model.live="search" placeholder="Search posts..." 
                        class="w-full pl-10 pr-4 py-3 bg-[#0F1014] border border-[#23242A] rounded-xl text-gray-200 placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none transition-all">
                </div>
            </div>

            <!-- List -->
            <div class="premium-card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-[#1A1B21] text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-6 py-4 font-semibold tracking-wider">Post Details</th>
                                <th class="px-6 py-4 font-semibold tracking-wider">Status</th>
                                <th class="px-6 py-4 font-semibold tracking-wider">Stats</th>
                                <th class="px-6 py-4 font-semibold tracking-wider text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#23242A]">
                            @forelse($posts as $post)
                                <tr class="group hover:bg-[#1A1B21]/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-lg bg-[#23242A] flex-shrink-0 overflow-hidden relative">
                                                @if($post->image_path)
                                                    <img src="{{ Storage::url($post->image_path) }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-600">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-white group-hover:text-indigo-400 transition-colors line-clamp-1">{{ $post->title }}</h3>
                                                <div class="flex items-center gap-2 mt-1">
                                                     <span class="text-[10px] uppercase tracking-wide text-gray-500 font-semibold">{{ $post->category }}</span>
                                                     <span class="text-gray-600 text-[10px]">•</span>
                                                     <span class="text-[10px] text-gray-500">{{ $post->created_at->format('M d, Y') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($post->is_published)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium bg-green-500/10 text-green-400 border border-green-500/20">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Published
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">
                                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> Draft
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3 text-sm text-gray-400">
                                            <span class="flex items-center gap-1" title="Views">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                {{ $post->views ?? 0 }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <button wire:click="edit({{ $post->id }})" class="p-2 text-gray-400 hover:text-white hover:bg-[#23242A] rounded-lg transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                            </button>
                                            <button wire:click="delete({{ $post->id }})" onclick="return confirm('Are you sure?')" class="p-2 text-gray-400 hover:text-red-400 hover:bg-[#23242A] rounded-lg transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                        No posts found. Write something amazing today!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-[#23242A]">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>

        <!-- Sidebar / Stats -->
        <div class="space-y-6">
            <div class="premium-card p-6">
                <h3 class="font-bold text-lg mb-4 text-white">Quick Stats</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 bg-[#1A1B21] border border-[#23242A] rounded-xl">
                        <span class="text-sm text-gray-400">Total Posts</span>
                        <span class="text-xl font-bold text-white">{{ $posts->total() }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-[#1A1B21] border border-[#23242A] rounded-xl">
                        <span class="text-sm text-gray-400">Published</span>
                        <span class="text-xl font-bold text-indigo-400">{{ $posts->where('is_published', true)->count() }}</span>
                    </div>
                </div>
            </div>
            
             <div class="premium-card p-6 bg-gradient-to-br from-indigo-900/20 to-purple-900/10 border-indigo-500/20">
                <h3 class="font-bold text-lg mb-2 text-white">Writing Tip</h3>
                <p class="text-xs text-gray-400 italic">"Consistency is key. Try to publish at least one technical article per week to build authority."</p>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-[100] p-4" wire:click.self="closeModal">
             <div class="bg-[#0F1014] border border-[#23242A] rounded-2xl w-full max-w-5xl h-[90vh] flex flex-col shadow-2xl animate-in fade-in zoom-in duration-200">
                <!-- Header -->
                <div class="flex justify-between items-center p-6 border-b border-[#23242A] bg-[#0A0A0A]">
                    <h2 class="text-xl font-bold text-white">{{ $editMode ? 'Edit Post' : 'New Post' }}</h2>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                
                <!-- Body -->
                <div class="flex-1 overflow-hidden flex flex-col lg:flex-row">
                    <!-- Main Editor Area -->
                    <div class="flex-1 overflow-y-auto p-8 custom-scrollbar space-y-6 border-r border-[#23242A]">
                        <div>
                            <input type="text" wire:model="title" class="w-full bg-transparent border-0 text-3xl font-bold text-white placeholder-gray-600 focus:ring-0 px-0" placeholder="Enter post title...">
                            @error('title') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        
                        <div wire:ignore>
                            <textarea id="editor" wire:model.defer="content" class="min-h-[500px]"></textarea>
                        </div>
                         @error('content') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Sidebar Settings -->
                    <div class="w-full lg:w-[320px] bg-[#0A0A0A] p-6 space-y-6 overflow-y-auto border-l border-[#23242A]">
                        <div>
                             <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Cover Image</label>
                             <div class="relative h-40 bg-[#1A1B21] border-2 border-dashed border-[#23242A] rounded-xl hover:border-gray-600 transition-colors flex flex-col items-center justify-center group cursor-pointer overflow-hidden">
                                @if($image)
                                     <p class="text-indigo-400 text-xs z-10 bg-black/50 px-2 py-1 rounded">New Image Set</p>
                                @elseif($editMode && $image_path)
                                     <img src="{{ Storage::url($image_path) }}" class="absolute inset-0 w-full h-full object-cover">
                                @else
                                    <svg class="w-8 h-8 text-gray-600 mb-2 group-hover:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span class="text-xs text-gray-500">Upload Cover</span>
                                @endif
                                <input type="file" wire:model="image" class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                        </div>

                         <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Category</label>
                            <select wire:model="category" class="w-full bg-[#1A1B21] border border-[#23242A] rounded-xl px-4 py-3 text-white focus:border-indigo-500 focus:outline-none text-sm">
                                <option value="Uncategorized">Select Category</option>
                                <option value="Tutorial">Tutorial</option>
                                <option value="Article">Article</option>
                                <option value="News">News</option>
                                <option value="Life">Life</option>
                            </select>
                        </div>
                        
                        <div class="bg-[#1A1B21] border border-[#23242A] rounded-xl p-4">
                            <label class="flex items-center justify-between cursor-pointer mb-2">
                                <span class="text-sm font-medium text-white">Publish Now</span>
                                <input type="checkbox" wire:model="is_published" class="form-checkbox h-5 w-5 text-indigo-500 rounded border-gray-600 bg-gray-800 focus:ring-0 focus:ring-offset-0">
                            </label>
                            <p class="text-xs text-gray-500">Make this post visible to the public immediately.</p>
                        </div>

                        <!-- Scheduling -->
                        <div class="bg-[#1A1B21] border border-[#23242A] rounded-xl p-4">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Schedule Publish</label>
                            <input type="datetime-local" wire:model="scheduled_at" class="w-full bg-[#0F1014] border border-[#23242A] rounded-lg px-3 py-2 text-white placeholder-gray-500 focus:border-indigo-500 text-sm">
                            <p class="text-xs text-gray-500 mt-2">Set a date to automatically publish this post.</p>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="p-6 border-t border-[#23242A] bg-[#0A0A0A] flex justify-end gap-3">
                    <button wire:click="closeModal" class="px-6 py-2.5 rounded-xl border border-[#23242A] text-gray-400 hover:text-white hover:bg-[#1A1B21] transition-colors font-medium text-sm">Cancel</button>
                    <button wire:click="save" class="btn-premium px-8 py-2.5 text-sm">Save Post</button>
                </div>
             </div>
        </div>

    @endif
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        let editorInstance = null;

        // Listen for the event dispatched from the component
        Livewire.on('open-modal', () => {
            // Wait for DOM to update
            setTimeout(() => {
                const editorElement = document.querySelector('#editor');
                if (editorElement) {
                    initCKEditor(editorElement);
                }
            }, 100); 
        });

        // Cleanup on re-renders if necessary (though modal closing usually handles this visually)
        // Ideally we destroy the editor when modal closes, but Livewire removing the DOM node does that implicitly
        
        function initCKEditor(element) {
            // Check if already initialized to prevent errors
            if (editorInstance) {
                editorInstance.destroy()
                    .then(() => createEditor(element))
                    .catch(error => console.error(error));
            } else {
                createEditor(element);
            }
        }

        function createEditor(element) {
            ClassicEditor
                .create(element, {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', '|', 'undo', 'redo'],
                    heading: {
                        options: [
                            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                            { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                            { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                            { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
                        ]
                    }
                })
                .then(editor => {
                    editorInstance = editor;
                    
                    // Set initial data
                    const initialContent = @this.get('content');
                    if(initialContent) {
                        editor.setData(initialContent);
                    }
                    
                    // Two-way binding
                    editor.model.document.on('change:data', () => {
                        @this.set('content', editor.getData());
                    });
                })
                .catch(error => console.error('CKEditor Init Error:', error));
        }
    });
</script>
</div>

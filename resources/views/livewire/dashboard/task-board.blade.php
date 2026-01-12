<div class="h-[calc(100vh-8rem)] flex flex-col space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center bg-[#0F1014] p-6 rounded-[20px] border border-[#23242A] flex-shrink-0">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white">Task Board</h1>
            <p class="text-gray-400 text-sm mt-1">Manage your workflow with premium focus</p>
        </div>
        <button wire:click="create" class="btn-premium px-6 py-2.5 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>New Task</span>
        </button>
    </div>

    <!-- Kanban Board -->
    <div class="flex-1 overflow-x-auto overflow-y-hidden pb-4">
        <div class="h-full flex gap-6 min-w-[1200px]">
             @foreach($columns as $colKey => $colTitle)
                <!-- Column -->
                <div class="flex-1 flex flex-col h-full bg-[#0F1014] border border-[#23242A] rounded-2xl overflow-hidden">
                    <!-- Column Header -->
                    <div class="p-4 border-b border-[#23242A] bg-[#0A0A0A] flex items-center justify-between">
                         <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full 
                                {{ $colKey === 'pending' ? 'bg-gray-500 box-shadow-gray' : '' }}
                                {{ $colKey === 'in_progress' ? 'bg-indigo-500 box-shadow-indigo' : '' }}
                                {{ $colKey === 'review' ? 'bg-purple-500 box-shadow-purple' : '' }}
                                {{ $colKey === 'completed' ? 'bg-green-500 box-shadow-green' : '' }}
                            "></div>
                            <h3 class="font-bold text-sm text-white uppercase tracking-wider">{{ $colTitle }}</h3>
                        </div>
                        <span class="text-xs font-mono font-bold text-gray-500 bg-[#1A1B21] border border-[#23242A] px-2 py-0.5 rounded">{{ $tasks->where('status', $colKey)->count() }}</span>
                    </div>
                    
                    <!-- Column Body -->
                    <div class="flex-1 overflow-y-auto p-4 space-y-3 custom-scrollbar bg-[#050505]">
                         @forelse($tasks->where('status', $colKey) as $task)
                            <div wire:key="task-{{ $task->id }}" class="group relative bg-[#1A1B21] border border-[#23242A] hover:border-indigo-500/50 rounded-xl p-4 shadow-sm hover:shadow-lg hover:shadow-indigo-500/5 transition-all cursor-grab active:cursor-grabbing">
                                 <!-- Priority Indicator -->
                                <div class="absolute left-0 top-4 bottom-4 w-1 rounded-r-full
                                    {{ $task->priority === 'urgent' ? 'bg-red-500 shadow-[0_0_8px_rgba(239,68,68,0.5)]' : '' }}
                                    {{ $task->priority === 'high' ? 'bg-orange-500' : '' }}
                                    {{ $task->priority === 'medium' ? 'bg-indigo-500' : '' }}
                                    {{ $task->priority === 'low' ? 'bg-gray-500' : '' }}
                                "></div>

                                <div class="pl-3">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="font-semibold text-sm text-gray-200 leading-snug group-hover:text-indigo-400 transition-colors line-clamp-2">{{ $task->title }}</h4>
                                        <button wire:click="edit({{ $task->id }})" class="text-gray-600 hover:text-white transition-colors opacity-0 group-hover:opacity-100 p-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </button>
                                    </div>

                                    @if($task->description)
                                        <p class="text-xs text-gray-500 line-clamp-2 mb-3 leading-relaxed">{{ $task->description }}</p>
                                    @endif

                                    <div class="flex items-center justify-between mt-3 pt-3 border-t border-[#23242A]">
                                        <span class="text-[10px] font-bold text-gray-500 bg-[#0A0A0A] border border-[#23242A] px-1.5 py-0.5 rounded uppercase tracking-wider max-w-[80px] truncate">
                                            {{ $task->internalProject ? $task->internalProject->name : 'General' }}
                                        </span>
                                        @if($task->due_at)
                                            <span class="text-[10px] flex items-center gap-1 font-medium {{ $task->due_at->isPast() && $task->status !== 'completed' ? 'text-red-400' : 'text-gray-500' }}">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                {{ $task->due_at->format('M d') }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <!-- Quick Actions -->
                                    <div class="absolute inset-x-0 bottom-0 p-2 bg-gradient-to-t from-[#1A1B21] to-transparent flex justify-center gap-4 opacity-0 group-hover:opacity-100 transition-all translate-y-2 group-hover:translate-y-0">
                                         @if($colKey !== 'pending')
                                            <button wire:click="updateStatus({{ $task->id }}, '{{ 
                                                $colKey === 'completed' ? 'review' : ($colKey === 'review' ? 'in_progress' : 'pending')
                                            }}')" class="p-1.5 bg-[#0F1014] border border-[#23242A] rounded-full text-gray-400 hover:text-white hover:border-indigo-500 transition-colors shadow-lg" title="Move Back">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                            </button>
                                        @endif
                                        
                                        <button wire:click="delete({{ $task->id }})" class="p-1.5 bg-[#0F1014] border border-[#23242A] rounded-full text-gray-400 hover:text-red-400 hover:border-red-500 transition-colors shadow-lg" title="Delete">
                                             <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>

                                        @if($colKey !== 'completed')
                                            <button wire:click="updateStatus({{ $task->id }}, '{{ 
                                                $colKey === 'pending' ? 'in_progress' : ($colKey === 'in_progress' ? 'review' : 'completed')
                                            }}')" class="p-1.5 bg-[#0F1014] border border-[#23242A] rounded-full text-gray-400 hover:text-white hover:border-indigo-500 transition-colors shadow-lg" title="Move Forward">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                             <div class="flex flex-col items-center justify-center p-8 text-center opacity-50">
                                <span class="text-2xl mb-2 text-gray-600">👻</span>
                                <p class="text-xs text-gray-500">No tasks here</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-[100] p-4" wire:click.self="closeModal">
             <div class="bg-[#0F1014] border border-[#23242A] rounded-2xl w-full max-w-lg shadow-2xl animate-in fade-in zoom-in duration-200">
                <div class="flex justify-between items-center p-6 border-b border-[#23242A] bg-[#0A0A0A]">
                    <h2 class="text-xl font-bold text-white">{{ $isEditing ? 'Edit Task' : 'New Task' }}</h2>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="p-8">
                    <form wire:submit.prevent="save" class="space-y-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Title</label>
                            <input type="text" wire:model="title" class="w-full bg-[#1A1B21] border border-[#23242A] rounded-xl px-4 py-3 text-white focus:border-indigo-500 focus:outline-none transition-colors" placeholder="e.g. Update Main Page">
                            @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Description</label>
                            <textarea wire:model="description" rows="3" class="w-full bg-[#1A1B21] border border-[#23242A] rounded-xl px-4 py-3 text-white focus:border-indigo-500 focus:outline-none transition-colors" placeholder="Details..."></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Status</label>
                                <select wire:model="status" class="w-full bg-[#1A1B21] border border-[#23242A] rounded-xl px-4 py-3 text-white focus:border-indigo-500 focus:outline-none transition-colors text-sm">
                                    <option value="pending">To Do</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="review">Review</option>
                                    <option value="completed">Done</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Priority</label>
                                <select wire:model="priority" class="w-full bg-[#1A1B21] border border-[#23242A] rounded-xl px-4 py-3 text-white focus:border-indigo-500 focus:outline-none transition-colors text-sm">
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                    <option value="urgent">Urgent</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Due Date</label>
                                <input type="date" wire:model="due_at" class="w-full bg-[#1A1B21] border border-[#23242A] rounded-xl px-4 py-3 text-gray-300 focus:border-indigo-500 focus:outline-none transition-colors text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Project</label>
                                <select wire:model="internal_project_id" class="w-full bg-[#1A1B21] border border-[#23242A] rounded-xl px-4 py-3 text-white focus:border-indigo-500 focus:outline-none transition-colors text-sm">
                                    <option value="">No Project</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="pt-6 flex justify-end gap-3">
                            <button type="button" wire:click="closeModal" class="px-6 py-2.5 rounded-xl border border-[#23242A] text-gray-400 hover:text-white hover:bg-[#1A1B21] transition-colors font-medium text-sm">Cancel</button>
                            <button type="submit" class="btn-premium px-8 py-2.5 text-sm">{{ $isEditing ? 'Update Task' : 'Create Task' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

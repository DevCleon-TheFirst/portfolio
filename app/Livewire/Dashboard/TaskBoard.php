<?php

namespace App\Livewire\Dashboard;

use App\Models\Task;
use App\Models\InternalProject;
use Livewire\Component;

class TaskBoard extends Component
{
    public $showModal = false;
    public $isEditing = false;
    public $editingTaskId;

    // Form Fields
    public $title = '';
    public $description = '';
    public $status = 'pending'; // pending, in_progress, review, completed
    public $priority = 'medium'; // low, medium, high
    public $due_at;
    public $internal_project_id;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'status' => 'required|in:pending,in_progress,review,completed',
        'priority' => 'required|in:low,medium,high,urgent',
        'due_at' => 'nullable|date',
        'internal_project_id' => 'nullable|exists:internal_projects,id',
    ];

    public function create()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $task = Task::where('user_id', auth()->id())->findOrFail($id);
        $this->editingTaskId = $id;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->status = $task->status;
        $this->priority = $task->priority;
        $this->due_at = $task->due_at ? $task->due_at->format('Y-m-d') : null;
        $this->internal_project_id = $task->internal_project_id;
        
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'user_id' => auth()->id(),
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'priority' => $this->priority,
            'due_at' => $this->due_at,
            'internal_project_id' => $this->internal_project_id,
        ];

        if ($this->isEditing) {
            Task::where('user_id', auth()->id())->where('id', $this->editingTaskId)->update($data);
            session()->flash('message', 'Task updated successfully!');
        } else {
            Task::create($data);
            session()->flash('message', 'Task created successfully!');
        }

        $this->closeModal();
    }

    public function updateStatus($taskId, $newStatus)
    {
        $task = Task::where('user_id', auth()->id())->findOrFail($taskId);
        $task->update(['status' => $newStatus]);
    }

    public function delete($id)
    {
        Task::where('user_id', auth()->id())->where('id', $id)->delete();
        session()->flash('message', 'Task deleted successfully!');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->title = '';
        $this->description = '';
        $this->status = 'pending';
        $this->priority = 'medium';
        $this->due_at = null;
        $this->internal_project_id = null;
        $this->editingTaskId = null;
    }

    public function render()
    {
        $tasks = Task::where('user_id', auth()->id())
            ->orderBy('priority', 'desc') // rudimentary sort
            ->orderBy('created_at', 'desc')
            ->get();

        $projects = InternalProject::where('user_id', auth()->id())->orderBy('title')->get();

        return view('livewire.dashboard.task-board', [
            'tasks' => $tasks,
            'projects' => $projects,
            'columns' => [
                'pending' => 'To Do',
                'in_progress' => 'In Progress',
                'review' => 'Review',
                'completed' => 'Done'
            ]
        ])->layout('layouts.dashboard');
    }
}

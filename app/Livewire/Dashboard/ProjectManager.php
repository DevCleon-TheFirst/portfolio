<?php

namespace App\Livewire\Dashboard;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class ProjectManager extends Component
{
    use WithPagination, WithFileUploads;

    public $showModal = false;
    public $editMode = false;
    public $projectId;
    
    // Form fields
    public $title = '';
    public $problem = '';
    public $solution = '';
    public $result = '';
    public $tech_stack = '';
    public $project_url = '';
    public $github_url = '';
    public $category = 'web';
    public $image;
    public $is_featured = false;
    
    public $search = '';

    protected $rules = [
        'title' => 'required|min:3',
        'problem' => 'required',
        'solution' => 'required',
        'result' => 'required',
        'tech_stack' => 'required',
        'category' => 'required',
    ];

    public function create()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $this->projectId = $id;
        $this->title = $project->title;
        $this->problem = $project->problem;
        $this->solution = $project->solution;
        $this->result = $project->result;
        $this->tech_stack = is_array($project->tech_stack) ? implode(', ', $project->tech_stack) : '';
        $this->project_url = $project->project_url ?? '';
        $this->github_url = $project->github_url ?? '';
        $this->category = $project->category;
        $this->is_featured = $project->is_featured;
        
        $this->editMode = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'problem' => $this->problem,
            'solution' => $this->solution,
            'result' => $this->result,
            'tech_stack' => array_map('trim', explode(',', $this->tech_stack)),
            'project_url' => $this->project_url,
            'github_url' => $this->github_url,
            'category' => $this->category,
            'is_featured' => $this->is_featured,
        ];

        if ($this->image) {
            $data['image_path'] = $this->image->store('projects', 'public');
        }

        if ($this->editMode) {
            Project::find($this->projectId)->update($data);
            session()->flash('message', 'Project updated successfully!');
        } else {
            Project::create($data);
            session()->flash('message', 'Project created successfully!');
        }

        $this->closeModal();
    }

    public function delete($id)
    {
        Project::find($id)->delete();
        session()->flash('message', 'Project deleted successfully!');
    }

    public function toggleFeatured($id)
    {
        $project = Project::find($id);
        $project->update(['is_featured' => !$project->is_featured]);
        session()->flash('message', 'Project featured status updated!');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->title = '';
        $this->problem = '';
        $this->solution = '';
        $this->result = '';
        $this->tech_stack = '';
        $this->project_url = '';
        $this->github_url = '';
        $this->category = 'web';
        $this->image = null;
        $this->is_featured = false;
        $this->projectId = null;
    }

    public function render()
    {
        $projects = Project::query()
            ->when($this->search, function($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('category', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.dashboard.project-manager', [
            'projects' => $projects
        ])->layout('layouts.dashboard');
    }
}

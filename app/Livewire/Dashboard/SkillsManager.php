<?php

namespace App\Livewire\Dashboard;

use App\Models\Skill;
use Livewire\Component;
use Livewire\WithPagination;

class SkillsManager extends Component
{
    use WithPagination;

    public $showModal = false;
    public $editMode = false;
    public $skillId;

    // Form fields
    public $name = '';
    public $category = 'frontend';
    public $proficiency = 50;
    public $icon = '';
    public $order = 0;

    protected $rules = [
        'name' => 'required',
        'category' => 'required',
        'proficiency' => 'required|integer|min:0|max:100',
        'icon' => 'nullable|string', // Could be a class name or SVG path mainly
        'order' => 'integer',
    ];

    public function create()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $skill = Skill::findOrFail($id);
        $this->skillId = $id;
        $this->name = $skill->name;
        $this->category = $skill->category;
        $this->proficiency = $skill->proficiency;
        $this->icon = $skill->icon;
        $this->order = $skill->order;

        $this->editMode = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'category' => $this->category,
            'proficiency' => $this->proficiency,
            'icon' => $this->icon,
            'order' => $this->order,
        ];

        if ($this->editMode) {
            Skill::find($this->skillId)->update($data);
            session()->flash('message', 'Skill updated successfully!');
        } else {
            Skill::create($data);
            session()->flash('message', 'Skill added successfully!');
        }

        $this->closeModal();
    }

    public function delete($id)
    {
        Skill::find($id)->delete();
        session()->flash('message', 'Skill deleted successfully!');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->name = '';
        $this->category = 'frontend';
        $this->proficiency = 50;
        $this->icon = '';
        $this->order = 0;
        $this->skillId = null;
    }

    public function render()
    {
        $skills = Skill::orderBy('category')->orderBy('order')->paginate(20);

        return view('livewire.dashboard.skills-manager', [
            'skills' => $skills
        ])->layout('layouts.dashboard');
    }
}

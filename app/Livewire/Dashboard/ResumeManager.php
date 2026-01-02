<?php

namespace App\Livewire\Dashboard;


use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ResumeManager extends Component
{
    use WithFileUploads;

    public $resume;
    public $currentResume;

    public function mount()
    {
        $this->currentResume = auth()->user()->resume_path;
    }

    public function save()
    {
        $this->validate([
            'resume' => 'required|file|mimes:pdf|max:10240', // 10MB Max
        ]);

        $path = $this->resume->store('resumes', 'public');

        // Delete old resume if exists
        if (auth()->user()->resume_path) {
            Storage::disk('public')->delete(auth()->user()->resume_path);
        }

        auth()->user()->update(['resume_path' => $path]);
        $this->currentResume = $path;
        
        $this->dispatch('resume-uploaded');
        $this->reset('resume');
        
        session()->flash('success', 'Resume updated successfully!');
    }

    public function render()
    {
        return view('livewire.dashboard.resume-manager');
    }
}

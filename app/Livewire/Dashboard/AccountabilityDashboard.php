<?php

namespace App\Livewire\Dashboard;


use Livewire\Component;
use App\Models\InternalProject;
use App\Models\AccountabilityMetric;
use App\Models\Task;
use Carbon\Carbon;

class AccountabilityDashboard extends Component
{
    public $newProjectTitle;
    public $showNewProjectModal = false;

    public function createProject()
    {
        $this->validate([
            'newProjectTitle' => 'required|min:3|max:255'
        ]);

        InternalProject::create([
            'user_id' => auth()->id(),
            'title' => $this->newProjectTitle,
            'status' => 'active',
            'start_date' => now(),
            'completion_percentage' => 0
        ]);

        $this->newProjectTitle = '';
        $this->showNewProjectModal = false;
        
        session()->flash('success', 'Project created successfully. Time to build!');
    }

    public function calculateStreak()
    {
        // Simple streak logic: Consecutive days with at least 1 completed task
        $streak = 0;
        $date = Carbon::yesterday();
        
        // check today first
        $todayMetric = AccountabilityMetric::where('user_id', auth()->id())->where('date', today())->first();
        if ($todayMetric && $todayMetric->tasks_completed > 0) {
            $streak++;
        }

        while (true) {
            $metric = AccountabilityMetric::where('user_id', auth()->id())->where('date', $date->format('Y-m-d'))->first();
            if ($metric && $metric->tasks_completed > 0) {
                $streak++;
                $date->subDay();
            } else {
                break;
            }
        }
        return $streak;
    }

    public function render()
    {
        $projects = InternalProject::where('user_id', auth()->id())
            ->withCount(['tasks as total_tasks', 'tasks as completed_tasks_count' => function ($query) {
                $query->where('status', 'completed');
            }])
            ->latest()
            ->get();

        // Calculate progress for each explicitly to ensure UI sync
        foreach ($projects as $project) {
            if ($project->total_tasks > 0) {
                $project->calculated_progress = round(($project->completed_tasks_count / $project->total_tasks) * 100);
            } else {
                $project->calculated_progress = 0;
            }
        }

        $metrics = AccountabilityMetric::where('user_id', auth()->id())
            ->where('date', '>=', now()->subDays(30))
            ->orderBy('date')
            ->get();

        return view('livewire.dashboard.accountability-dashboard', [
            'projects' => $projects,
            'metrics' => $metrics,
            'currentStreak' => $this->calculateStreak(),
            'totalFocusTime' => $metrics->sum('focus_time'), // Last 30 days
            'avgDiscipline' => $metrics->avg('discipline_score') ?? 0,
        ])->layout('layouts.dashboard');
    }
}

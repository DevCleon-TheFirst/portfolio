<?php

namespace App\Livewire\Dashboard;

use App\Models\Task;
use App\Models\FocusSession;
use Livewire\Component;
use Livewire\Attributes\On;

class FocusTimer extends Component
{
    public $timeLeft = 1500; // 25 minutes in seconds
    public $totalTime = 1500;
    public $mode = 'focus'; // focus, break, custom
    public $isActive = false;
    public $selectedTaskId;
    public $currentSessionId;
    
    // For UI
    public $pageTitle = 'Focus Timer';

    public function mount()
    {
        // Check if there's an active session? 
        // For simplicity, we restart state on page load for now, 
        // but robust implementation would check db/cache.
    }

    public function updatedSelectedTaskId()
    {
        $this->resetTimer();
    }

    public function startTimer()
    {
        if (!$this->selectedTaskId && $this->mode === 'focus') {
            $this->addError('task', 'Please select a task to focus on.');
            return;
        }

        $this->isActive = true;

        if ($this->mode === 'focus') {
            // Create session record
            $session = FocusSession::create([
                'user_id' => auth()->id(),
                'task_id' => $this->selectedTaskId,
                'started_at' => now(),
                'completed' => false,
            ]);
            $this->currentSessionId = $session->id;
            
            // Update task status if pending
            $task = Task::find($this->selectedTaskId);
            if ($task && $task->status === 'pending') {
                $task->update(['status' => 'in_progress']);
            }
        }
    }

    public function pauseTimer()
    {
        $this->isActive = false;
    }

    public function resetTimer()
    {
        $this->isActive = false;
        $this->timeLeft = $this->totalTime;
        $this->currentSessionId = null;
    }

    public function setMode($mode)
    {
        $this->mode = $mode;
        
        switch ($mode) {
            case 'break':
                $this->totalTime = 300;
                break;
            case 'focus':
                $this->totalTime = 1500;
                break;
            case 'custom':
                $this->totalTime = 2700; // Default 45 mins
                break;
        }
        
        $this->resetTimer();
    }

    public function setCustomTime($minutes)
    {
        $this->mode = 'custom';
        $this->totalTime = $minutes * 60;
        $this->resetTimer();
    }

    #[On('timer-finished')] 
    public function handleTimerFinished()
    {
        $this->isActive = false;
        
        if ($this->mode === 'focus' && $this->currentSessionId) {
            $session = FocusSession::find($this->currentSessionId);
            if ($session) {
                $session->endSession();
            }
            $this->dispatch('play-sound', 'complete');
            
            // Auto switch to break?
            // For now, let user choose.
        }
    }

    public function render()
    {
        $tasks = Task::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'in_progress', 'review'])
            ->orderBy('priority', 'desc')
            ->get();

        $recentSessions = FocusSession::where('user_id', auth()->id())
            ->with(['task.internalProject']) // Eager load relationships
            ->latest()
            ->take(5)
            ->get();
            
        // Daily stats
        $dailyMinutes = FocusSession::where('user_id', auth()->id())
            ->whereDate('created_at', today())
            ->sum('duration');

        return view('livewire.dashboard.focus-timer', [
            'tasks' => $tasks,
            'recentSessions' => $recentSessions,
            'dailyMinutes' => $dailyMinutes
        ])->layout('layouts.dashboard');
    }
}

<?php

namespace App\Livewire\Dashboard;

use App\Models\Task;
use App\Models\InternalProject;
use App\Models\BlogPost;
use App\Models\Project;
use App\Models\ContactMessage;
use Livewire\Component;

class Overview extends Component
{
    public $stats = [];
    public $recentTasks = [];
    public $upcomingTasks = [];
    public $disciplineScore = 0;

    public function mount()
    {
        $this->loadStats();
        $this->loadTasks();
        $this->disciplineScore = auth()->user()->discipline_score;
    }

    public function loadStats()
    {
        $this->stats = [
            'total_tasks' => Task::where('user_id', auth()->id())->count(),
            'completed_tasks' => Task::where('user_id', auth()->id())->completed()->count(),
            'pending_tasks' => Task::where('user_id', auth()->id())->pending()->count(),
            'active_projects' => InternalProject::where('user_id', auth()->id())->active()->count(),
            'blog_posts' => BlogPost::count(),
            'published_posts' => BlogPost::published()->count(),
            'portfolio_projects' => Project::count(),
            'unread_messages' => ContactMessage::unread()->count(),
            
            // Visitor Analytics
            'total_views' => \App\Models\PageView::getTotalViews(),
            'unique_visitors' => \App\Models\PageView::getUniqueVisitors(),
            'today_views' => \App\Models\PageView::getTodayViews(),
            'week_views' => \App\Models\PageView::getThisWeekViews(),
        ];
    }

    public function loadTasks()
    {
        $this->recentTasks = Task::where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        $this->upcomingTasks = Task::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->whereNotNull('due_at')
            ->orderBy('due_at')
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.dashboard.overview', [
            'totalTasks' => $this->stats['total_tasks'],
            'completedTasks' => $this->stats['completed_tasks'],
            'pendingTasks' => $this->stats['pending_tasks'],
            'activeProjects' => $this->stats['active_projects'],
            'totalBlogPosts' => $this->stats['blog_posts'],
            'totalViews' => $this->stats['total_views'],
            'totalPortfolioProjects' => $this->stats['portfolio_projects'],
            'unreadMessages' => $this->stats['unread_messages'],
            'recentTasks' => $this->recentTasks,
            'upcomingTasks' => $this->upcomingTasks,
            
            // Visitor Analytics
            'uniqueVisitors' => $this->stats['unique_visitors'],
            'todayViews' => $this->stats['today_views'],
            'weekViews' => $this->stats['week_views'],
            'popularPages' => \App\Models\PageView::getPopularPages(5),
            'dailyViews' => \App\Models\PageView::getDailyViews(7),
            'deviceStats' => \App\Models\PageView::getDeviceStats(),
            'topCountries' => \App\Models\PageView::getTopCountries(5),
            'browserStats' => \App\Models\PageView::getBrowserStats(),
        ])->layout('layouts.dashboard');
    }
}

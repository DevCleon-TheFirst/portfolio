<?php

namespace App\Livewire\Dashboard;


use Livewire\Component;
use App\Models\SystemActivityLog;

class NotificationsDropdown extends Component
{
    public function markAsRead()
    {
        SystemActivityLog::whereNull('read_at')->update(['read_at' => now()]);
    }

    public function render()
    {
        return view('livewire.dashboard.notifications-dropdown', [
            'logs' => SystemActivityLog::latest()->take(10)->get(),
            'unreadCount' => SystemActivityLog::whereNull('read_at')->count(),
        ]);
    }
}

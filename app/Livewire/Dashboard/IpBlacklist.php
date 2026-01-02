<?php

namespace App\Livewire\Dashboard;

use App\Models\IpBlacklist as IpBlacklistModel;
use Livewire\Component;
use Livewire\WithPagination;

class IpBlacklist extends Component
{
    use WithPagination;

    public $ip_address = '';
    public $reason = 'manual';
    public $notes = '';
    public $expires_days = null;
    public $showAddForm = false;

    protected $rules = [
        'ip_address' => 'required|ip',
        'reason' => 'required|in:manual,spam_detected,suspicious',
        'notes' => 'nullable|string|max:500',
        'expires_days' => 'nullable|integer|min:1|max:365',
    ];

    public function addIp()
    {
        $this->validate();

        $expiresAt = $this->expires_days ? now()->addDays($this->expires_days) : null;

        IpBlacklistModel::addToBlacklist(
            $this->ip_address,
            $this->reason,
            $expiresAt,
            auth()->id(),
            $this->notes
        );

        session()->flash('message', 'IP address added to blacklist successfully!');
        
        $this->reset(['ip_address', 'reason', 'notes', 'expires_days']);
        $this->showAddForm = false;
    }

    public function removeIp($id)
    {
        $blacklist = IpBlacklistModel::find($id);
        
        if ($blacklist) {
            IpBlacklistModel::removeFromBlacklist($blacklist->ip_address);
            session()->flash('message', 'IP address removed from blacklist successfully!');
        }
    }

    public function render()
    {
        $blacklists = IpBlacklistModel::latest()->paginate(20);
        
        $stats = [
            'total' => IpBlacklistModel::count(),
            'active' => IpBlacklistModel::active()->count(),
            'expired' => IpBlacklistModel::expired()->count(),
            'today' => IpBlacklistModel::whereDate('blocked_at', today())->count(),
        ];

        return view('livewire.dashboard.ip-blacklist', [
            'blacklists' => $blacklists,
            'stats' => $stats,
        ])->layout('layouts.dashboard');
    }
}

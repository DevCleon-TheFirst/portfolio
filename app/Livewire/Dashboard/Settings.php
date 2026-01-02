<?php

namespace App\Livewire\Dashboard;

use App\Models\Setting;
use Livewire\Component;

class Settings extends Component
{
    public $social_github = '';
    public $social_facebook = '';
    public $social_whatsapp = '';
    public $social_x = '';
    public $social_threads = '';
    public $social_linkedin = '';

    public function mount()
    {
        $this->social_github = Setting::get('social_github', '');
        $this->social_facebook = Setting::get('social_facebook', '');
        $this->social_whatsapp = Setting::get('social_whatsapp', '');
        $this->social_x = Setting::get('social_x', '');
        $this->social_threads = Setting::get('social_threads', '');
        $this->social_linkedin = Setting::get('social_linkedin', '');
    }

    public function save()
    {
        $this->validate([
            'social_github' => 'nullable|url',
            'social_facebook' => 'nullable|url',
            'social_whatsapp' => 'nullable|string',
            'social_x' => 'nullable|url',
            'social_threads' => 'nullable|url',
            'social_linkedin' => 'nullable|url',
        ]);

        Setting::set('social_github', $this->social_github, 'url', 'social_media');
        Setting::set('social_facebook', $this->social_facebook, 'url', 'social_media');
        Setting::set('social_whatsapp', $this->social_whatsapp, 'text', 'social_media');
        Setting::set('social_x', $this->social_x, 'url', 'social_media');
        Setting::set('social_threads', $this->social_threads, 'url', 'social_media');
        Setting::set('social_linkedin', $this->social_linkedin, 'url', 'social_media');

        session()->flash('message', 'Social media links updated successfully!');
    }

    public function render()
    {
        return view('livewire.dashboard.settings')->layout('layouts.dashboard');
    }
}

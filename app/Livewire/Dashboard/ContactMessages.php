<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\ContactMessage;
use Livewire\WithPagination;

class ContactMessages extends Component
{
    use WithPagination;
    
    public $selectedMessage = null;
    public $showModal = false;
    
    public function viewMessage($id)
    {
        $this->selectedMessage = ContactMessage::findOrFail($id);
        $this->selectedMessage->markAsRead();
        $this->showModal = true;
    }
    
    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedMessage = null;
    }
    
    public function deleteMessage($id)
    {
        ContactMessage::findOrFail($id)->delete();
        session()->flash('success', 'Message deleted successfully.');
    }
    
    public function render()
    {
        return view('livewire.dashboard.contact-messages', [
            'messages' => ContactMessage::latest()->paginate(15),
            'unreadCount' => ContactMessage::unread()->count(),
        ])->layout('layouts.dashboard');
    }
}

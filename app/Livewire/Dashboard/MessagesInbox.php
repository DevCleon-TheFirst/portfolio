<?php

namespace App\Livewire\Dashboard;

use App\Models\ContactMessage;
use Livewire\Component;
use Livewire\WithPagination;

class MessagesInbox extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all'; // all, unread, read
    public $selectedMessageId = null;

    protected $queryString = ['search', 'filter'];

    public function mount()
    {
        // Auto select first message if available? Maybe better to let user pick.
    }

    public function getSelectedMessageProperty()
    {
        return $this->selectedMessageId 
            ? ContactMessage::find($this->selectedMessageId) 
            : null;
    }

    public function selectMessage($id)
    {
        $this->selectedMessageId = $id;
        $message = ContactMessage::find($id);
        if ($message && !$message->is_read) {
            $message->markAsRead();
        }
    }

    public function delete($id)
    {
        $message = ContactMessage::find($id);
        if ($message) {
            $message->delete();
            if ($this->selectedMessageId == $id) {
                $this->selectedMessageId = null;
            }
            session()->flash('message', 'Message deleted successfully.');
        }
    }

    public function markAsUnread($id)
    {
        $message = ContactMessage::find($id);
        if ($message) {
            $message->update(['is_read' => false]);
            // If currently selected, we might want to refresh view, 
            // but Livewire handles data binding well.
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilter()
    {
        $this->resetPage();
        $this->selectedMessageId = null;
    }

    public function render()
    {
        $messages = ContactMessage::query()
            ->when($this->search, function($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('email', 'like', '%'.$this->search.'%')
                  ->orWhere('subject', 'like', '%'.$this->search.'%');
            })
            ->when($this->filter === 'unread', fn($q) => $q->where('is_read', false))
            ->when($this->filter === 'read', fn($q) => $q->where('is_read', true))
            ->latest()
            ->paginate(10);

        return view('livewire.dashboard.messages-inbox', [
            'messages' => $messages,
            'selectedMessage' => $this->selectedMessage,
            'unreadCount' => ContactMessage::unread()->count()
        ])->layout('layouts.dashboard');
    }
}

<?php

namespace App\Livewire\Dashboard;

use App\Models\TimelineEvent;
use Livewire\Component;
use Livewire\WithPagination;

class TimelineManager extends Component
{
    use WithPagination;

    public $showModal = false;
    public $editMode = false;
    public $eventId;

    // Form fields
    public $title = '';
    public $description = '';
    public $event_type = 'education'; // education, work, milestone, etc.
    public $date;
    public $icon = '';
    public $order = 0;

    protected $rules = [
        'title' => 'required',
        'description' => 'nullable',
        'event_type' => 'required',
        'date' => 'required|date',
        'icon' => 'nullable|string',
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
        $event = TimelineEvent::findOrFail($id);
        $this->eventId = $id;
        $this->title = $event->title;
        $this->description = $event->description;
        $this->event_type = $event->event_type;
        $this->date = $event->date->format('Y-m-d'); // Access date via cast often returns Carbon
        $this->icon = $event->icon;
        $this->order = $event->order;

        $this->editMode = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'event_type' => $this->event_type,
            'date' => $this->date,
            'icon' => $this->icon,
            'order' => $this->order,
        ];

        if ($this->editMode) {
            TimelineEvent::find($this->eventId)->update($data);
            session()->flash('message', 'Event updated successfully!');
        } else {
            TimelineEvent::create($data);
            session()->flash('message', 'Event added successfully!');
        }

        $this->closeModal();
    }

    public function delete($id)
    {
        TimelineEvent::find($id)->delete();
        session()->flash('message', 'Event deleted successfully!');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->title = '';
        $this->description = '';
        $this->event_type = 'work';
        $this->date = date('Y-m-d');
        $this->icon = '';
        $this->order = 0;
        $this->eventId = null;
    }

    public function render()
    {
        $events = TimelineEvent::orderBy('date', 'desc')->paginate(15);

        return view('livewire.dashboard.timeline-manager', [
            'events' => $events
        ])->layout('layouts.dashboard');
    }
}

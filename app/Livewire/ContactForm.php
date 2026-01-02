<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ContactMessage;

class ContactForm extends Component
{
    public $name = '';
    public $email = '';
    public $subject = '';
    public $message = '';
    
    protected $rules = [
        'name' => 'required|min:2|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'nullable|max:255',
        'message' => 'required|min:10|max:5000',
    ];
    
    public function submit()
    {
        $this->validate();
        
        ContactMessage::create([
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
            'ip_address' => request()->ip(),
        ]);
        
        session()->flash('success', 'Thank you for your message! I\'ll get back to you soon.');
        
        $this->reset(['name', 'email', 'subject', 'message']);
    }
    
    public function render()
    {
        return view('livewire.contact-form');
    }
}

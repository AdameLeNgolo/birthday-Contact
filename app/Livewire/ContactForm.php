<?php

namespace App\Livewire;

use App\Models\Contact;
use Livewire\Component;

class ContactForm extends Component
{

    public Contact $contact;
    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $phone = '';
    public $birth_date = '';
    public $notes = '';

    protected $rules = [
        'first_name' => 'required|min:2',
        'last_name' => 'required|min:2',
        'email' => 'nullable|email',
        'phone' => 'nullable|string',
        'birth_date' => 'required|date|before:today',
        'notes' => 'nullable|string'
    ];

    public function mount(Contact $contact)
    {
        if ($contact->exists) {
            $this->contact = $contact;
            $this->first_name = $contact->first_name;
            $this->last_name = $contact->last_name;
            $this->email = $contact->email;
            $this->phone = $contact->phone;
            $this->birth_date = $contact->birth_date->format('Y-m-d');
            $this->notes = $contact->notes;
        } else {
            $this->contact = new Contact();
        }
    }

    public function save()
    {
        $this->validate();

        $this->contact->fill([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'birth_date' => $this->birth_date,
            'notes' => $this->notes,
        ]);

        $this->contact->save();

        session()->flash('message', $this->contact->wasRecentlyCreated ?
            'Contact créé avec succès.' : 'Contact mis à jour avec succès.');

        return redirect()->route('contacts.index');
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}

<?php

namespace App\Livewire;

use App\Models\Contact;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class ContactList extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'first_name';
    public $sortDirection = 'asc';
    public $filterBy = 'all';

    protected $queryString = ['search', 'sortBy', 'sortDirection', 'filterBy'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function deleteContact($id)
    {
        Contact::find($id)->delete();
        session()->flash('message', 'Contact supprimé avec succès.');
    }

    public function render()
    {
        $query = Contact::query();

        // Filtrage par recherche
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }
        // Filtrage par période
        switch ($this->filterBy) {
            case 'today':
                $query->birthdaysToday();
                break;
            case 'this_month':
                $query->birthdaysThisMonth();
                break;
            case 'next_30_days':
                $query->whereBetween('birth_date', [
                    Carbon::today()->format('m-d'),
                    Carbon::today()->addDays(30)->format('m-d')
                ]);
                break;
        }

        // Tri
        $query->orderBy($this->sortBy, $this->sortDirection);

        return view('livewire.contact-list', [
            'contacts' => $query->paginate(10),
            'birthdaysToday' => Contact::birthdaysToday()->get(),
            'birthdaysThisMonth' => Contact::birthdaysThisMonth()->get()
        ]);
    }
}

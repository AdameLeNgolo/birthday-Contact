<?php

use App\Livewire\ContactForm;
use App\Livewire\ContactList;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', ContactList::class)->name('contacts.index');
Route::get('/contacts/create', ContactForm::class)->name('contacts.create');
Route::get('/contacts/{contact}/edit', ContactForm::class)->name('contacts.edit');

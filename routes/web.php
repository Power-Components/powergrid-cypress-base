<?php

use App\Livewire\Filters\InputText;
use Illuminate\Support\Facades\Route;

Route::get('/filters-input-text', InputText::class);
Route::get('/filters-number', \App\Livewire\Filters\Number::class);

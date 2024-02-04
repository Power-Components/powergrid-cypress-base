<?php

use App\Livewire\Filters\InputText;
use App\Livewire\Filters\Number;
use App\Livewire\Filters\NumberJoin;
use Illuminate\Support\Facades\Route;

Route::get('/filters-input-text', InputText::class);
Route::get('/filters-number', Number::class);
Route::get('/filters-number-join', NumberJoin::class);

<?php

use App\Livewire\Actions\Can;
use App\Livewire\Actions\Disable;
use App\Livewire\Actions\Attributes;
use App\Livewire\Filters\InputText;
use App\Livewire\Filters\Number;
use App\Livewire\Filters\NumberJoin;
use App\Livewire\Filters\Select;
use App\Livewire\Filters\SelectJoin;
use Illuminate\Support\Facades\Route;

Route::get('/filters-input-text', InputText::class);
Route::get('/filters-number', Number::class);
Route::get('/filters-number-join', NumberJoin::class);
Route::get('/filters-select', Select::class);
Route::get('/filters-select-join', SelectJoin::class);

# actions
Route::get('/actions-attributes', Attributes::class);
Route::get('/actions-can', Can::class);
Route::get('/actions-disable', Disable::class);

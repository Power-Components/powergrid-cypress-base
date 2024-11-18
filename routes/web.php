<?php

use App\Livewire\ActionRules\ButtonAttributes;
use App\Livewire\ActionRules\ButtonBladeComponent;
use App\Livewire\ActionRules\ButtonDisable;
use App\Livewire\ActionRules\ButtonHide;
use App\Livewire\ActionRules\SetUpToggleColumns;
use App\Livewire\Actions\Can;
use App\Livewire\Actions\Disable;
use App\Livewire\Actions\Attributes;
use App\Livewire\Filters\InputText;
use App\Livewire\Filters\Number;
use App\Livewire\Filters\NumberJoin;
use App\Livewire\Filters\Select;
use App\Livewire\Filters\SelectJoin;
use App\Livewire\Header\HeaderCan;
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

# action rules
Route::get('/action-rules-button-hide', ButtonHide::class);
Route::get('/action-rules-button-disable', ButtonDisable::class);
Route::get('/action-rules-button-setattribute', ButtonAttributes::class);
Route::get('/action-rules-button-bladecomponent', ButtonBladeComponent::class);

Route::get('/setup-toggle-columns', SetUpToggleColumns::class);

Route::get('/header-can', HeaderCan::class);

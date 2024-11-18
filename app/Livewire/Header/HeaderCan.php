<?php

namespace App\Livewire\Header;

use App\Livewire\BaseTable;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\Facades\Rule;

final class HeaderCan extends BaseTable
{
    public string $tableName = 'header-can';

    public function header(): array
    {
        return [
            Button::add('visible')
                ->slot('Visible')
                ->can(fn() => true)
                ->dataCy('btn-header-visible')
                ->dispatch('nothing', []),

            Button::add('invisible')
                ->slot('Invisible')
                ->can(fn() => false)
                ->dataCy('btn-header-invisible')
                ->dispatch('nothing', []),
        ];
    }
}

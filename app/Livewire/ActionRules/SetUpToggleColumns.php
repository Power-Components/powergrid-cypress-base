<?php

namespace App\Livewire\ActionRules;

use App\Livewire\BaseTable;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\Facades\Rule;

final class SetUpToggleColumns extends BaseTable
{
    public string $tableName = 'setup-toggle-columns';

    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showToggleColumns()
                ->showSearchInput()
        ];
    }
}

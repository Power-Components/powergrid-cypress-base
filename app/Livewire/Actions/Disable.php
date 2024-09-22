<?php

namespace App\Livewire\Actions;

use App\Livewire\BaseTable;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;

final class Disable extends BaseTable
{
    public string $tableName = 'actions-disable';

    public function actions($row): array
    {
        return [
            Button::add('disable')
                ->slot('Disable')
                ->dataCy('btn-disable-'.$row->id)
                ->class('text-slate-500 items-center flex gap-2 hover:text-slate-700 hover:bg-slate-100 p-1 px-2 rounded')
                ->disable($row->id === 2),
        ];
    }

    #[On('clickToEdit')]
    public function clickToEdit(string $action, string $name): void
    {
        $this->js("console.log(\"Editing #{$action} -  {$name}\")");
    }
}

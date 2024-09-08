<?php

namespace App\Livewire\Actions;

use App\Livewire\BaseTable;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;

final class Dispatch extends BaseTable
{
    public function actions($row): array
    {
        return [
            Button::add('dispatch')
                ->slot('Dispatch')
                ->dataCy('btn-dispatch-'.$row->id)
                ->class('text-slate-500 items-center flex gap-2 hover:text-slate-700 hover:bg-slate-100 p-1 px-2 rounded')
                ->dispatch('clickToEdit', ['action' => 'view', 'name' => $row?->name]),
        ];
    }

    #[On('clickToEdit')]
    public function clickToEdit(string $action, string $name): void
    {
        $this->js("console.log(\"Editing #{$action} -  {$name}\")");
    }
}

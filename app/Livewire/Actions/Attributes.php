<?php

namespace App\Livewire\Actions;

use App\Livewire\BaseTable;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;

final class Attributes extends BaseTable
{
    public function actions($row): array
    {
        return [
            Button::add('view')
                ->icon('default-eye', [
                    'class' => '!text-green-500',
                ])
                ->slot('View')
                ->dataCy('btn-view-'.$row->id)
                ->class('text-slate-500 items-center flex gap-2 hover:text-slate-700 hover:bg-slate-100 p-1 px-2 rounded')
                ->dispatch('clickToEdit', ['action' => 'view', 'name' => $row?->name]),

            Button::add('edit')
                ->icon('default-pencil', [
                    'class' => '!text-green-500',
                ])
                ->slot('Edit')
                ->dataCy('btn-edit-'.$row->id)
                ->class('text-slate-500 items-center flex gap-2 hover:text-slate-700 hover:bg-slate-100 p-1 px-2 rounded')
                ->dispatch('clickToEdit', ['action' => 'edit', 'name' => $row?->name]),
        ];
    }

    #[On('clickToEdit')]
    public function clickToEdit(string $action, string $name): void
    {
        $this->js("console.log(\"Editing #{$action} -  {$name}\")");
    }
}

<?php

namespace App\Livewire\Actions;

use App\Livewire\BaseTable;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;

final class Can extends BaseTable
{
    public string $tableName = 'actions-can';

    public function actions($row): array
    {
        return [
            Button::add('can')
                ->slot('*Can*')
                ->dataCy('btn-can-'.$row->id)
                ->class('text-slate-500 items-center flex gap-2 hover:text-slate-700 hover:bg-slate-100 p-1 px-2 rounded')
                ->can(fn ($row) => $row->id === 2),

            Button::add('cannot')
                ->slot('*Cannot*')
                ->dataCy('btn-cannot-'.$row->id)
                ->class('text-slate-500 items-center flex gap-2 hover:text-slate-700 hover:bg-slate-100 p-1 px-2 rounded')
                ->can(fn ($row) => $row->id !== 2),
        ];
    }
}

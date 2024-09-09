<?php

namespace App\Livewire\ActionRules;

use App\Livewire\BaseTable;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Facades\Rule;

final class ButtonDisable extends BaseTable
{
    public function actions($row): array
    {
        return [
            Button::add('edit')
                ->slot('Edit-'.$row->id)
                ->dataCy('btn-edit-'.$row->id),

            Button::add('delete')
                ->slot('Delete-'.$row->id)
                ->dataCy('btn-delete-'.$row->id)
        ];
    }

    public function actionRules(): array
    {
        return [
            Rule::button('edit')
                ->when(fn ($dish) => $dish->id == 1)
                ->disable(),

            Rule::button('delete')
                ->when(fn ($dish) => $dish->id == 2)
                ->disable(),
        ];
    }
}

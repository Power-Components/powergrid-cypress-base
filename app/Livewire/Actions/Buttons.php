<?php

namespace App\Livewire\Actions;

use App\Traits\Dish;
use App\Traits\DishSeeder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class Buttons extends PowerGridComponent
{
    use DishSeeder;

    private function migrate(): void
    {
        Schema::create('dishes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->timestamps();
        });
    }

    private function getDishSeeder(): array
    {
        return [
            ['name' => 'Luan', 'email' => 'luanfreitasdev@fakemail.com'],
            ['name' => 'Daniel', 'email' => 'dansysanalyst@fakemail.com'],
            ['name' => 'Claudio', 'email' => 'claudio@fakemail.com'],
            ['name' => 'Vitor', 'email' => 'vitao@fakemail.com'],
            ['name' => 'Tio Jobs', 'email' => 'tiojobs'],
        ];
    }

    protected function queryString(): array
    {
        return [
            'search' => ['except' => null],
            'page' => ['except' => 1],
            ...$this->powerGridQueryString(),
        ];
    }

    public function datasource()
    {
        return Dish::query();
    }

    public function setUp(): array
    {
        return [
            PowerGrid::header()->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('email')
            ->add('created_at_formatted', function ($entry) {
                return Carbon::parse($entry->created_at)->format('d/m/Y');
            });
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),

            Column::make('Name', 'name')
                ->searchable()
                ->sortable(),

            Column::make('E-mail', 'email')
                ->sortable(),

            Column::make('Created', 'created_at_formatted'),

            Column::action('Actions')
        ];
    }

    public function actions($row): array
    {
        return [
            Button::add('view')
                ->icon('default-eye', [
                    'class' => '!text-green-500',
                ])
                ->slot('View')
                ->class('text-slate-500 items-center flex gap-2 hover:text-slate-700 hover:bg-slate-100 p-1 px-2 rounded')
                ->dispatch('clickToEdit', ['action' => 'view', 'name' => $row?->name]),
            Button::add('edit')
                ->icon('default-pencil', [
                    'class' => '!text-blue-500',
                ])
                ->slot('Edit')
                ->class('text-slate-500 items-center flex gap-2 hover:text-slate-700 hover:bg-slate-100 p-1 px-2 rounded')
                ->dispatch('clickToEdit', ['action' => 'edit', 'name' => $row?->name]),
            Button::add('download')
                ->icon('default-download', [
                    'class' => '!text-slate-500',
                ])
                ->slot('Download')
                ->class('text-slate-500 items-center flex gap-2 hover:text-slate-700 hover:bg-slate-100  p-1 px-2 rounded')
                ->dispatch('clickToEdit', ['action' => 'download', 'name' => $row?->name]),
            Button::add('delete')
                ->slot('Delete')
                ->icon('default-trash', [
                    'class' => 'text-red-500',
                ])
                ->class('text-slate-500 items-center flex gap-2 hover:text-slate-700 hover:bg-slate-100 p-1 px-2 rounded')
                ->dispatch('clickToEdit', ['action' => 'delete', 'name' => $row?->name]),
        ];
    }

    #[On('clickToEdit')]
    public function clickToEdit(string $action, string $name): void
    {
        $this->js("console.log(\"Editing #{$action} -  {$name}\")");
    }
}

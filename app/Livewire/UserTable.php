<?php

namespace App\Livewire;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class UserTable extends PowerGridComponent
{
    protected function queryString(): array
    {
        return [
            'search' => ['except' => null],
            'page' => ['except' => 1],
            ...$this->powerGridQueryString(),
        ];
    }

    public function datasource(): ?Collection
    {
        return collect([
            ['id' => 1, 'name' => 'Luan', 'email' => 'luanfreitasdev@fakemail.com', 'created_at' => now(),],
            ['id' => 2, 'name' => 'Daniel', 'email' => 'dansysanalyst@fakemail.com', 'created_at' => now(),],
            ['id' => 3, 'name' => 'Claudio', 'email' => 'claudio@fakemail.com', 'created_at' => now(),],
            ['id' => 4, 'name' => 'Vitor', 'email' => 'vitao@fakemail.com', 'created_at' => now(),],
            ['id' => 5, 'name' => 'Tio Jobs', 'email' => 'tiojobs', 'created_at' => now(),],
        ]);
    }

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Header::make()->showSearchInput(),
            Footer::make()
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
        ];
    }

    public function filters(): array
    {
        if (request()->query('testTypes') == 'rules') {
            return [];
        }

        return [
            Filter::inputText('name'),
            Filter::inputText('email'),
        ];
    }

}

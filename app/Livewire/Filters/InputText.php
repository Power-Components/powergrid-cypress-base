<?php

namespace App\Livewire\Filters;

use App\Traits\Datasources;
use App\Traits\PowerGridSeeder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class InputText extends PowerGridComponent
{
    use PowerGridSeeder;

    private function getSchema()
    {
        Schema::create('datasources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->timestamps();
        });
    }

    private function getList(): array
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
        return Datasources::query();
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
        return [
            Filter::inputText('name'),
            Filter::inputText('email'),
        ];
    }
}
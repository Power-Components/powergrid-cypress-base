<?php

namespace App\Livewire\Filters;

use App\Traits\Dish;
use App\Traits\DishSeeder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class Number extends PowerGridComponent
{
    use DishSeeder;

    private function migrate()
    {
        Schema::create('dishes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('calories');
            $table->timestamps();
        });
    }

    private function getDishSeeder(): array
    {
        return [
            ['name' => 'Spicy Tofu Stir Fry', 'calories' => 130, 'created_at' => now()],
            ['name' => 'Quinoa Salad with Avocado', 'calories' => 230, 'created_at' => now()],
            ['name' => 'Mango Chicken Curry', 'calories' => 330, 'created_at' => now()],
            ['name' => 'Grilled Salmon with Lemon Dill Sauce', 'calories' => 430, 'created_at' => now()],
            ['name' => 'Vegetarian Buddha Bowl', 'calories' => 530, 'created_at' => now()],
            ['name' => 'Pasta Primavera', 'calories' => 630, 'created_at' => now()],
            ['name' => 'Blueberry Almond Smoothie Bowl', 'calories' => 730, 'created_at' => now()],
            ['name' => 'Grilled Vegetable Wrap', 'calories' => 830, 'created_at' => now()],
            ['name' => 'Chocolate Avocado Mousse', 'calories' => 930, 'created_at' => now()],
            ['name' => 'Caprese Salad', 'calories' => 1030, 'created_at' => now()],
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
            ->add('calories')
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

            Column::make('Calories', 'calories')
                ->sortable(),

            Column::make('Created', 'created_at_formatted'),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::number('calories'),
        ];
    }
}

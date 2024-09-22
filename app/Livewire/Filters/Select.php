<?php

namespace App\Livewire\Filters;

use App\Traits\Category;
use App\Traits\Dish;
use App\Traits\DishSeeder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class Select extends PowerGridComponent
{
    use DishSeeder;

    public string $tableName = 'filters-select';

    protected function prepareDatasource(): void
    {
        Schema::dropIfExists('dishes');
        Schema::dropIfExists('categories');

        $this->migrate();

        DB::table('dishes')->insert($this->getDishSeeder());
        DB::table('categories')->insert($this->getCategoryList());
    }

    private function migrate(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('dishes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(Category::Class);
            $table->timestamps();
        });
    }

    private function getDishSeeder(): array
    {
        return [
            ['name' => 'Spicy Tofu Stir Fry', 'category_id' => 1],
            ['name' => 'Quinoa Salad with Avocado', 'category_id' => 2],
            ['name' => 'Mango Chicken Curry', 'category_id' => 3],
            ['name' => 'Grilled Salmon with Lemon Dill Sauce', 'category_id' => 1],
            ['name' => 'Vegetarian Buddha Bowl', 'category_id' => 2],
            ['name' => 'Pasta Primavera', 'category_id' => 3],
            ['name' => 'Blueberry Almond Smoothie Bowl', 'category_id' => 1],
            ['name' => 'Grilled Vegetable Wrap', 'category_id' => 2],
            ['name' => 'Chocolate Avocado Mousse', 'category_id' => 3],
            ['name' => 'Caprese Salad', 'category_id' => 1],
        ];
    }

    private function getCategoryList(): array
    {
        return [
            ['name' => 'Meat'],
            ['name' => 'Fish'],
            ['name' => 'Garnish'],
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
        return Dish::with('category');
    }

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::header()
                ->showSearchInput(),
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
            ->add('category', function ($entry) {
                return $entry->category->name;
            })
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

            Column::make('Category', 'category'),

            Column::make('Created', 'created_at_formatted'),
        ];
    }

    public function filters(): array
    {
        $categories = Schema::hasTable('categories') ? Category::all() : collect();

        return [
            Filter::select('category', 'category_id')
                ->dataSource($categories)
                ->optionLabel('name')
                ->optionValue('id'),
        ];
    }
}

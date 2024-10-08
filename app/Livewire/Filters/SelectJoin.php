<?php

namespace App\Livewire\Filters;

use App\Traits\Category;
use App\Traits\DishSeeder;
use App\Traits\Dish;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class SelectJoin extends PowerGridComponent
{
    use DishSeeder;

    public string $tableName = 'filters-select-join';

    protected function prepareDatasource(): void
    {
        Schema::dropIfExists('dishes');
        Schema::dropIfExists('categories');

        $this->migrate();

        DB::table('dishes')->insert($this->getDishSeeder());
        DB::table('categories')->insert($this->getCategoryList());
    }

    private function migrate()
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
            ['name' => 'Spicy Tofu Stir Fry', 'category_id' => 1, 'created_at' => now()],
            ['name' => 'Quinoa Salad with Avocado', 'category_id' => 2, 'created_at' => now()],
            ['name' => 'Mango Chicken Curry', 'category_id' => 3, 'created_at' => now()],
            ['name' => 'Grilled Salmon with Lemon Dill Sauce', 'category_id' => 1, 'created_at' => now()],
            ['name' => 'Vegetarian Buddha Bowl', 'category_id' => 2, 'created_at' => now()],
            ['name' => 'Pasta Primavera', 'category_id' => 3, 'created_at' => now()],
            ['name' => 'Blueberry Almond Smoothie Bowl', 'category_id' => 1, 'created_at' => now()],
            ['name' => 'Grilled Vegetable Wrap', 'category_id' => 2, 'created_at' => now()],
            ['name' => 'Chocolate Avocado Mousse', 'category_id' => 3, 'created_at' => now()],
            ['name' => 'Caprese Salad', 'category_id' => 1, 'created_at' => now()],
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
        return Dish::query()
            ->join('categories', function ($categories) {
                $categories->on('dishes.category_id', '=', 'categories.id');
            })
            ->select('dishes.*');
    }

    public function setUp(): array
    {
        $this->showCheckBox();

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

            Column::make('Category', 'category', 'categories.id')
                ->sortable(),

            Column::make('Created', 'created_at_formatted'),
        ];
    }

    public function filters(): array
    {
        $categories = Schema::hasTable('categories') ? Category::all() : collect();

        return [
            Filter::select('category', 'dishes.category_id')
                ->dataSource($categories)
                ->optionLabel('name')
                ->optionValue('id'),
        ];
    }
}

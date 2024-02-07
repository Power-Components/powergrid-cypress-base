<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\Url;
use PowerComponents\LivewirePowerGrid\Themes\Bootstrap5;
use PowerComponents\LivewirePowerGrid\Themes\Tailwind;

trait DishSeeder
{
    #[Url]
    public string $powerGridTheme = 'tailwind';

    public function template(): ?string
    {
        return $this->powerGridTheme == 'bootstrap'
            ? Bootstrap5::class
            : Tailwind::class;
    }

    public function mount(): void
    {
        $this->prepareDatasource();

        parent::mount();
    }

    protected function prepareDatasource(): void
    {
        Schema::dropIfExists('dishes');

        $this->migrate();

        DB::table('dishes')->insert($this->getDishSeeder());
    }
}

class Dish extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

class Category extends Model
{

}

<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\Url;
use PowerComponents\LivewirePowerGrid\Themes\Bootstrap5;
use PowerComponents\LivewirePowerGrid\Themes\Tailwind;

trait InitialState
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
        Schema::dropIfExists('datasources');

        $this->getSchema();

        Schema::disableForeignKeyConstraints();

        DB::table('datasources')->truncate();

        DB::table('datasources')->insert($this->getList());

        Schema::enableForeignKeyConstraints();
    }
}

class Datasources extends Model
{

}

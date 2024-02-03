<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait PowerGridSeeder
{
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

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use PowerComponents\LivewirePowerGrid\Themes\Bootstrap5;
use PowerComponents\LivewirePowerGrid\Themes\Tailwind;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $theme = request()->query('powerGridTheme');

        config(['livewire-powergrid.theme' => $theme == 'bootstrap' ? Bootstrap5::class : Tailwind::class]);
    }
}

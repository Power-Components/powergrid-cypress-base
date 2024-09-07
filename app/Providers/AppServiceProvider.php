<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Themes\Bootstrap5;
use PowerComponents\LivewirePowerGrid\Themes\Tailwind;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $theme = request()->query('powerGridTheme');

        config(['livewire-powergrid.theme' => $theme == 'bootstrap' ? Bootstrap5::class : Tailwind::class]);
    }

    public function boot()
    {
        Button::macro('dataCy', function (string $value) {
            $this->attributes([
                'data-cy' => $value
            ]);

            return $this;
        });
    }
}

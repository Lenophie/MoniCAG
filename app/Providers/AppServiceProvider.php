<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('components.header', 'header');
        Blade::component('components.menu-button', 'menubutton');
        Blade::component('components.modal', 'modal');

        Validator::extend('positive', function($attribute, $value, $parameters, $validator) {
            return $value >= 0;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

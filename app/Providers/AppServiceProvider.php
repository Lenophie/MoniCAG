<?php

namespace App\Providers;

use App\InventoryItem;
use App\InventoryItemStatus;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Blade::component('components.header', 'header');
        Blade::component('components.menu-button', 'menubutton');
        Blade::component('components.modal', 'modal');
        Blade::component('components.user-icon', 'usericon');
        Blade::component('components.button-enabler', 'buttonenabler');

        Validator::extend('inventory_item_available', 'App\Validators\InventoryItemAvailable@validate');
        Validator::extend('password_for', 'App\Validators\PasswordFor@validate');
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

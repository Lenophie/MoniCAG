<?php

namespace App\Providers;

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
        Validator::extend('inventory_item_not_borrowed', 'App\Validators\InventoryItemNotBorrowed@validate');
        Validator::extend('no_self_return', 'App\Validators\NoSelfReturn@validate');
        Validator::extend('password_for', 'App\Validators\PasswordFor@validate');
        Validator::extend('unchanged_during_borrowing', 'App\Validators\UnchangedDuringBorrowing@validate');
        Validator::extend('not_changed_to_borrowed', 'App\Validators\NotChangedToBorrowed@validate');
        Validator::extend('unchanged_if_other_admin', 'App\Validators\UnchangedIfOtherAdmin@validate');

        Validator::replacer('distinct', 'App\Validators\Distinct@replacer');
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

<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\Resource;
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
        Resource::withoutWrapping();

        Schema::defaultStringLength(191);

        Blade::component('components.header', 'header');
        Blade::component('components.menu-button', 'menubutton');
        Blade::component('components.user-icon', 'usericon');
        Blade::component('components.button-enabler', 'buttonenabler');

        Validator::extend('inventory_item_available', 'App\Validators\InventoryItemAvailable@validate');
        Validator::extend('inventory_item_not_borrowed', 'App\Validators\InventoryItemNotBorrowed@validate');
        Validator::extend('no_self_return', 'App\Validators\NoSelfReturn@validate');
        Validator::extend('not_already_returned', 'App\Validators\BorrowingNotAlreadyReturned@validate');
        Validator::extend('password_for', 'App\Validators\PasswordFor@validate');
        Validator::extend('unchanged_during_borrowing', 'App\Validators\UnchangedDuringBorrowing@validate');
        Validator::extend('not_changed_to_borrowed', 'App\Validators\NotChangedToBorrowed@validate');
        Validator::extend('not_involved_in_a_current_borrowing', 'App\Validators\NotInvolvedInACurrentBorrowing@validate');
        Validator::extend('current_user_password', 'App\Validators\CurrentUserPassword@validate');
        Validator::extend('not_the_only_genre_of_an_inventory_item', 'App\Validators\NotTheOnlyGenreOfAnInventoryItem@validate');

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

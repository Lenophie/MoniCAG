<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Passport::tokensCan([
            'see-borrowings' => 'see borrowings',
            'edit-borrowings' => 'edit borrowings',
            'see-inventory-items' => 'see inventory items',
            'edit-inventory-items' => 'edit inventory items',
            'see-users' => 'see users',
            'edit-users' => 'edit users',
            'see-genres' => 'see genres',
            'edit-genres' => 'edit genres'
        ]);
    }
}

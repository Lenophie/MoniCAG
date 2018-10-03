<?php

use App\UserRole;
use Carbon\Carbon;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    $year = Carbon::now()->year;
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'promotion' => rand($year - 7, $year + 7),
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt($faker->unique()->password),
        'role_id' => UserRole::NONE,
        'remember_token' => str_random(10),
    ];
});

$factory->state(App\User::class, 'lender', function (Faker $faker) {
    return [
        'role_id' => UserRole::LENDER
    ];
});

$factory->state(App\User::class, 'admin', function (Faker $faker) {
    return [
        'role_id' => UserRole::ADMINISTRATOR
    ];
});


<?php

/** @var Factory $factory */
use App\User;
use App\UserRole;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(User::class, function (Faker $faker) {
    $year = Carbon::now()->year;
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'promotion' => rand($year - 7, $year + 7),
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt($faker->unique()->password),
        'role_id' => UserRole::NONE,
        'remember_token' => Str::random(10),
    ];
});

$factory->state(User::class, 'lender', ['role_id' => UserRole::LENDER]);
$factory->state(User::class, 'admin', ['role_id' => UserRole::ADMINISTRATOR]);


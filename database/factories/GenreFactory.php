<?php

/** @var Factory $factory */
use App\Genre;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Genre::class, function (Faker $faker) {
    return [
        'name_fr' => $faker->unique()->word,
        'name_en' => $faker->unique()->word,
    ];
});

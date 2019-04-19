<?php

use App\Genre;
use Faker\Generator as Faker;

$factory->faker->seed(0);

$factory->define(Genre::class, function (Faker $faker) {
    return [
        'name_fr' => $faker->unique()->word,
        'name_en' => $faker->unique()->word,
    ];
});

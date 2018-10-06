<?php

use App\Genre;
use Faker\Generator as Faker;

$factory->define(Genre::class, function (Faker $faker) {
    return [
        'name_fr' => $faker->unique()->word,
        'name_en' => $faker->unique()->word,
    ];
});

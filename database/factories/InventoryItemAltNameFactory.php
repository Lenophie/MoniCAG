<?php

/** @var Factory $factory */
use App\InventoryItemAltName;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(InventoryItemAltName::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word,
    ];
});

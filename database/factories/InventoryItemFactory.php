<?php

use App\InventoryItemStatus;
use Faker\Generator as Faker;

$factory->define(App\InventoryItem::class, function (Faker $faker) {
    $durationMin = $faker->numberBetween(1, 120);
    $durationMax = $faker->numberBetween($durationMin, 180);
    $playersMin = $faker->numberBetween(1, 8);
    $playersMax = $faker->numberBetween($playersMin, 60);
    return [
        'name_fr' => $faker->word,
        'name_en' => $faker->word,
        'duration_min' => $durationMin,
        'duration_max' => $durationMax,
        'players_min' => $playersMin,
        'players_max' => $playersMax,
        'status_id' => InventoryItemStatus::IN_LCR_D4
    ];
});
// TODO : Add some genres

$factory->state(App\InventoryItem::class, 'in_F2', ['status_id' => InventoryItemStatus::IN_F2]);
$factory->state(App\InventoryItem::class, 'borrowed', ['status_id' => InventoryItemStatus::BORROWED]);
$factory->state(App\InventoryItem::class, 'lost', ['status_id' => InventoryItemStatus::LOST]);
$factory->state(App\InventoryItem::class, 'unknown', ['status_id' => InventoryItemStatus::UNKNOWN]);

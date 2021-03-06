<?php
/** @var Factory $factory */
use App\Genre;
use App\InventoryItem;
use App\InventoryItemAltName;
use App\InventoryItemStatus;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(InventoryItem::class, function (Faker $faker) {
    $durationMin = rand(1, 20);
    $durationMax = rand($durationMin, 180);
    $playersMin = rand(1, 8);
    $playersMax = rand($playersMin, 60);
    return [
        'name' => $faker->unique()->word,
        'duration_min' => $durationMin,
        'duration_max' => $durationMax,
        'players_min' => $playersMin,
        'players_max' => $playersMax,
        'status_id' => InventoryItemStatus::IN_LCR_D4
    ];
});

$factory->afterCreating(InventoryItem::class, function ($inventoryItem, Faker $faker) {
    $inventoryItem->genres()->saveMany(factory(Genre::class, 3)->make());
    $inventoryItem->altNames()->saveMany(factory(InventoryItemAltName::class, 2)->make());
});

$factory->state(InventoryItem::class, 'in_F2', ['status_id' => InventoryItemStatus::IN_F2]);
$factory->state(InventoryItem::class, 'borrowed', ['status_id' => InventoryItemStatus::BORROWED]);
$factory->state(InventoryItem::class, 'lost', ['status_id' => InventoryItemStatus::LOST]);
$factory->state(InventoryItem::class, 'unknown', ['status_id' => InventoryItemStatus::UNKNOWN]);

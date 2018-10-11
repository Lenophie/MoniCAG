<?php

use App\Borrowing;
use App\InventoryItem;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Borrowing::class, function (Faker $faker) {
    $startDate = Carbon::now()->subDays(rand(1, 10));
    return [
        'inventory_item_id' => function () {
            return factory(InventoryItem::class)->state('borrowed')->create()->id;
        },
        'initial_lender_id' => function () {
            return factory(User::class)->state('lender')->create()->id;
        },
        'borrower_id' => function () {
            return factory(User::class)->create()->id;
        },
        'guarantee' => $faker->numberBetween(0, 100),
        'finished' => false,
        'start_date' => $startDate,
        'expected_return_date' => $startDate->copy()->addDays(rand(1, 3)),
        'return_date' => null,
        'notes_before' => $faker->text,
        'notes_after' => null
    ];
});

$factory->state(Borrowing::class, 'onTime', function() {
    $now = Carbon::now();
    $startDate = $now->copy()->subDays(rand(5, 10));
    $expectedReturnDate = $now->copy()->addDays(rand(1, 3));

    return [
        'start_date' => $startDate,
        'expected_return_date' => $expectedReturnDate
    ];
});

$factory->state(Borrowing::class, 'late', function() {
    $now = Carbon::now();
    $startDate = $now->copy()->subDays(rand(5, 10));
    $expectedReturnDate = $now->copy()->subDays(rand(1, 3));

    return [
        'start_date' => $startDate,
        'expected_return_date' => $expectedReturnDate
    ];
});

$factory->state(Borrowing::class, 'finished', function(Faker $faker) {
    return [
        'finished' => true,
        'return_lender_id' => function () {
            return factory(User::class)->state('lender')->create()->id;
        },
        'return_date' => function (array $borrowing) {
            return $borrowing['start_date']->copy()->addDays(rand(1, 5));
        },
        'notes_after' => $faker->text
    ];
});

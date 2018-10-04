<?php

namespace Tests\Feature;

use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BorrowedItemsValidationTest extends TestCase
{


    public $otherAvailableInventoryItems;

    protected function setUp()
    {
        Parent::setUp();

        $lender = factory(User::class)->state('lender')->create();
        $this->actingAs($lender);
        $this->otherAvailableInventoryItems = factory(InventoryItem::class, 10)->create();
    }

    /**
     * Tests borrowed items requirement validation.
     *
     * @return void
     */
    public function testBorrowedItemsRequirement()
    {
        $response = $this->json('POST', '/new-borrowing', []);
        $response->assertJsonValidationErrors('borrowedItems');
    }

    /**
     * Tests borrowed items not an array rejection.
     */
    public function testBorrowedItemsNotAnArrayRejection()
    {
        $response = $this->json('POST', '/new-borrowing', [
            'borrowedItems' => 'I am a string'
        ]);
        $response->assertJsonValidationErrors('borrowedItems');
        $response = $this->json('POST', '/new-borrowing', [
            'borrowedItems' => 1
        ]);
        $response->assertJsonValidationErrors('borrowedItems');
        $response = $this->json('POST', '/new-borrowing', [
            'borrowedItems' => null
        ]);
        $response->assertJsonValidationErrors('borrowedItems');
    }

    /**
     * Tests borrowed item value not an integer rejection.
     */
    public function testBorrowedItemValueNotAnIntegerRejection()
    {
        $response = $this->json('POST', '/new-borrowing', [
            'borrowedItems' => ['I am a string']
        ]);
        $response->assertJsonValidationErrors('borrowedItems.0');
        $response = $this->json('POST', '/new-borrowing', [
            'borrowedItems' => [null]
        ]);
        $response->assertJsonValidationErrors('borrowedItems.0');
        $response = $this->json('POST', '/new-borrowing', [
            'borrowedItems' => [[0]]
        ]);
        $response->assertJsonValidationErrors('borrowedItems.0');
    }

    /**
     * Tests single borrowed item validation.
     *
     * @return void
     */
    public function testSingleBorrowedItemValidation()
    {
        $singleItemToBorrow = factory(InventoryItem::class, 1)->create();
        $response = $this->json('POST', '/new-borrowing', [
            'borrowedItems' => [$singleItemToBorrow[0]->id]
        ]);
        $response->assertJsonMissingValidationErrors('borrowedItems.0');
    }

    /**
     * Tests multiple borrowed items validation
     *
     * @return void
     */
    public function testMultipleBorrowedItemsValidation()
    {
        $multipleItemsToBorrow = factory(InventoryItem::class, 5)->create();
        $multipleItemsToBorrowIDs = [];
        foreach ($multipleItemsToBorrow as $itemToBorrow) array_push($multipleItemsToBorrowIDs, $itemToBorrow->id);
        $response = $this->json('POST', '/new-borrowing', [
            'borrowedItems' => $multipleItemsToBorrowIDs
        ]);
        for ($i = 0; $i < 5; $i++) $response->assertJsonMissingValidationErrors('borrowedItems.' . $i);
    }

    /**
     * Tests borrowing of already borrowed item rejection
     *
     * @return void
     */
    public function testBorrowAlreadyBorrowedItemsRejection()
    {
        $multipleItemsToBorrow = factory(InventoryItem::class, 5)->create();
        $alreadyBorrowedItem = factory(InventoryItem::class, 1)->state('borrowed')->create();

        $multipleItemsToBorrowIDs = [];
        foreach ($multipleItemsToBorrow as $itemToBorrow) array_push($multipleItemsToBorrowIDs, $itemToBorrow->id);
        array_push($multipleItemsToBorrowIDs, $alreadyBorrowedItem[0]->id);

        $response = $this->json('POST', '/new-borrowing', [
            'borrowedItems' => $multipleItemsToBorrowIDs
        ]);
        $response->assertJsonValidationErrors('borrowedItems.5');
    }

    /**
     * Tests borrowing of lost item rejection
     *
     * @return void
     */
    public function testBorrowLostItemsRejection()
    {
        $multipleItemsToBorrow = factory(InventoryItem::class, 5)->create();
        $lostItem = factory(InventoryItem::class, 1)->state('lost')->create();

        $multipleItemsToBorrowIDs = [];
        foreach ($multipleItemsToBorrow as $itemToBorrow) array_push($multipleItemsToBorrowIDs, $itemToBorrow->id);
        array_push($multipleItemsToBorrowIDs, $lostItem[0]->id);

        $response = $this->json('POST', '/new-borrowing', [
            'borrowedItems' => $multipleItemsToBorrowIDs
        ]);
        $response->assertJsonValidationErrors('borrowedItems.5');
    }

    /**
     * Tests borrowing of item with unknown location rejection
     *
     * @return void
     */
    public function testBorrowItemsWithUnknownLocationRejection()
    {
        $multipleItemsToBorrow = factory(InventoryItem::class, 5)->create();
        $unknownLocationItem = factory(InventoryItem::class, 1)->state('unknown')->create();

        $multipleItemsToBorrowIDs = [];
        foreach ($multipleItemsToBorrow as $itemToBorrow) array_push($multipleItemsToBorrowIDs, $itemToBorrow->id);
        array_push($multipleItemsToBorrowIDs, $unknownLocationItem[0]->id);

        $response = $this->json('POST', '/new-borrowing', [
            'borrowedItems' => $multipleItemsToBorrowIDs
        ]);
        $response->assertJsonValidationErrors('borrowedItems.5');
    }
}

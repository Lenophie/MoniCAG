<?php

use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BorrowedItemsValidationTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp()
    {
        Parent::setUp();
        $lender = factory(User::class)->state('lender')->create();
        $this->actingAs($lender, 'api');
    }

    /**
     * Tests borrowed items requirement.
     *
     * @return void
     */
    public function testBorrowedItemsRequirement()
    {
        $response = $this->json('POST', '/api/borrowings', []);
        $response->assertJsonValidationErrors('borrowedItems');
        $response = $this->json('POST', '/api/borrowings', [
            'borrowedItems' => []
        ]);
        $response->assertJsonValidationErrors('borrowedItems');
    }

    /**
     * Tests borrowed items not an array rejection.
     */
    public function testBorrowedItemsNotAnArrayRejection()
    {
        $response = $this->json('POST', '/api/borrowings', [
            'borrowedItems' => 'I am a string'
        ]);
        $response->assertJsonValidationErrors('borrowedItems');
        $response = $this->json('POST', '/api/borrowings', [
            'borrowedItems' => 1
        ]);
        $response->assertJsonValidationErrors('borrowedItems');
        $response = $this->json('POST', '/api/borrowings', [
            'borrowedItems' => null
        ]);
        $response->assertJsonValidationErrors('borrowedItems');
    }

    /**
     * Tests borrowed item value not an integer rejection.
     */
    public function testBorrowedItemValueNotAnIntegerRejection()
    {
        $response = $this->json('POST', '/api/borrowings', [
            'borrowedItems' => ['I am a string']
        ]);
        $response->assertJsonValidationErrors('borrowedItems.0');
        $response = $this->json('POST', '/api/borrowings', [
            'borrowedItems' => [null]
        ]);
        $response->assertJsonValidationErrors('borrowedItems.0');
        $response = $this->json('POST', '/api/borrowings', [
            'borrowedItems' => [[0]]
        ]);
        $response->assertJsonValidationErrors('borrowedItems.0');
    }

    /**
     * Tests borrowing of non existent item rejection.
     */
    public function testBorrowingOfNonExistentItemRejection()
    {
        $someInventoryItems = factory(InventoryItem::class, 5)->create();
        $someInventoryItemsIDs = [];
        foreach ($someInventoryItems as $inventoryItem) array_push($someInventoryItemsIDs, $inventoryItem->id);
        $nonExistenceInventoryItemID = max($someInventoryItemsIDs) + 1;
        $response = $this->json('POST', '/api/borrowings', [
            'borrowedItems' => [$nonExistenceInventoryItemID]
        ]);
        $response->assertJsonValidationErrors('borrowedItems.0');
    }

    /**
     * Tests borrowing of duplicate item rejection.
     */
    public function testBorrowingOfDuplicateItemRejection()
    {
        $singleItemToBorrow = factory(InventoryItem::class)->create();
        $response = $this->json('POST', '/api/borrowings', [
            'borrowedItems' => [$singleItemToBorrow->id, $singleItemToBorrow->id]
        ]);
        $response->assertJsonValidationErrors('borrowedItems.0');
    }

    /**
     * Tests single borrowed item validation.
     *
     * @return void
     */
    public function testBorrowingOfSingleBorrowedItemValidation()
    {
        $singleItemToBorrow = factory(InventoryItem::class)->create();
        $response = $this->json('POST', '/api/borrowings', [
            'borrowedItems' => [$singleItemToBorrow->id]
        ]);
        $response->assertJsonMissingValidationErrors('borrowedItems.0');
    }

    /**
     * Tests multiple borrowed items validation
     *
     * @return void
     */
    public function testBorrowingOfMultipleBorrowedItemsValidation()
    {
        $multipleItemsToBorrow = factory(InventoryItem::class, 5)->create();
        $multipleItemsToBorrowIDs = [];
        foreach ($multipleItemsToBorrow as $itemToBorrow) array_push($multipleItemsToBorrowIDs, $itemToBorrow->id);
        $response = $this->json('POST', '/api/borrowings', [
            'borrowedItems' => $multipleItemsToBorrowIDs
        ]);
        for ($i = 0; $i < 5; $i++) $response->assertJsonMissingValidationErrors("borrowedItems.{$i}");
    }

    /**
     * Tests borrowing of already borrowed item rejection
     *
     * @return void
     */
    public function testBorrowingOfAlreadyBorrowedItemsRejection()
    {
        $multipleItemsToBorrow = factory(InventoryItem::class, 5)->create();
        $alreadyBorrowedItem = factory(InventoryItem::class)->state('borrowed')->create();

        $multipleItemsToBorrowIDs = [];
        foreach ($multipleItemsToBorrow as $itemToBorrow) array_push($multipleItemsToBorrowIDs, $itemToBorrow->id);
        array_push($multipleItemsToBorrowIDs, $alreadyBorrowedItem->id);

        $response = $this->json('POST', '/api/borrowings', [
            'borrowedItems' => $multipleItemsToBorrowIDs
        ]);
        $response->assertJsonValidationErrors('borrowedItems.5');
    }

    /**
     * Tests borrowing of lost item rejection
     *
     * @return void
     */
    public function testBorrowingOfLostItemsRejection()
    {
        $multipleItemsToBorrow = factory(InventoryItem::class, 5)->create();
        $lostItem = factory(InventoryItem::class)->state('lost')->create();

        $multipleItemsToBorrowIDs = [];
        foreach ($multipleItemsToBorrow as $itemToBorrow) array_push($multipleItemsToBorrowIDs, $itemToBorrow->id);
        array_push($multipleItemsToBorrowIDs, $lostItem->id);

        $response = $this->json('POST', '/api/borrowings', [
            'borrowedItems' => $multipleItemsToBorrowIDs
        ]);
        $response->assertJsonValidationErrors('borrowedItems.5');
    }

    /**
     * Tests borrowing of item with unknown location rejection
     *
     * @return void
     */
    public function testBorrowingOfItemsWithUnknownLocationRejection()
    {
        $multipleItemsToBorrow = factory(InventoryItem::class, 5)->create();
        $unknownLocationItem = factory(InventoryItem::class)->state('unknown')->create();

        $multipleItemsToBorrowIDs = [];
        foreach ($multipleItemsToBorrow as $itemToBorrow) array_push($multipleItemsToBorrowIDs, $itemToBorrow->id);
        array_push($multipleItemsToBorrowIDs, $unknownLocationItem->id);

        $response = $this->json('POST', '/api/borrowings', [
            'borrowedItems' => $multipleItemsToBorrowIDs
        ]);
        $response->assertJsonValidationErrors('borrowedItems.5');
    }
}

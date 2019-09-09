<?php

use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BorrowedItemsValidationTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
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
        $response = $this->json('POST', route('borrowings.store'), []);
        $response->assertJsonValidationErrors('borrowedItems');
        $response = $this->json('POST', route('borrowings.store'), [
            'borrowedItems' => []
        ]);
        $response->assertJsonValidationErrors('borrowedItems');
    }

    /**
     * Tests borrowed items not an array rejection.
     */
    public function testBorrowedItemsNotAnArrayRejection()
    {
        $response = $this->json('POST', route('borrowings.store'), [
            'borrowedItems' => 'I am a string'
        ]);
        $response->assertJsonValidationErrors('borrowedItems');

        $response = $this->json('POST', route('borrowings.store'), [
            'borrowedItems' => 1
        ]);
        $response->assertJsonValidationErrors('borrowedItems');

        $response = $this->json('POST', route('borrowings.store'), [
            'borrowedItems' => null
        ]);
        $response->assertJsonValidationErrors('borrowedItems');
    }

    /**
     * Tests borrowed item value not an integer rejection.
     */
    public function testBorrowedItemValueNotAnIntegerRejection()
    {
        $response = $this->json('POST', route('borrowings.store'), [
            'borrowedItems' => ['I am a string']
        ]);
        $response->assertJsonValidationErrors('borrowedItems.0');

        $response = $this->json('POST', route('borrowings.store'), [
            'borrowedItems' => [null]
        ]);
        $response->assertJsonValidationErrors('borrowedItems.0');

        $response = $this->json('POST', route('borrowings.store'), [
            'borrowedItems' => [[0]]
        ]);
        $response->assertJsonValidationErrors('borrowedItems.0');
    }

    /**
     * Tests borrowing of non existent item rejection.
     */
    public function testBorrowingOfNonExistentItemRejection()
    {
        $nonExistentInventoryItemID = factory(InventoryItem::class, 5)->create()->max('id') + 1;

        $response = $this->json('POST', route('borrowings.store'), [
            'borrowedItems' => [$nonExistentInventoryItemID]
        ]);
        $response->assertJsonValidationErrors('borrowedItems.0');
    }

    /**
     * Tests borrowing of duplicate item rejection.
     */
    public function testBorrowingOfDuplicateItemRejection()
    {
        $singleItemToBorrow = factory(InventoryItem::class)->create();

        $response = $this->json('POST', route('borrowings.store'), [
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

        $response = $this->json('POST', route('borrowings.store'), [
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
        $multipleItemsToBorrowIDs = factory(InventoryItem::class, 5)->create()->pluck('id');

        $response = $this->json('POST', route('borrowings.store'), [
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
        $multipleItemsToBorrowIDs = factory(InventoryItem::class, 5)->create()->pluck('id');
        $alreadyBorrowedItemId = factory(InventoryItem::class)->state('borrowed')->create()->id;

        $multipleItemsToBorrowIDs->push($alreadyBorrowedItemId);

        $response = $this->json('POST', route('borrowings.store'), [
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
        $multipleItemsToBorrowIDs = factory(InventoryItem::class, 5)->create()->pluck('id');
        $lostItemId = factory(InventoryItem::class)->state('lost')->create()->id;

        $multipleItemsToBorrowIDs->push($lostItemId);

        $response = $this->json('POST', route('borrowings.store'), [
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
        $multipleItemsToBorrowIDs = factory(InventoryItem::class, 5)->create()->pluck('id');
        $unknownLocationItemId = factory(InventoryItem::class)->state('unknown')->create()->id;

        $multipleItemsToBorrowIDs->push($unknownLocationItemId);

        $response = $this->json('POST', route('borrowings.store'), [
            'borrowedItems' => $multipleItemsToBorrowIDs
        ]);
        $response->assertJsonValidationErrors('borrowedItems.5');
    }
}

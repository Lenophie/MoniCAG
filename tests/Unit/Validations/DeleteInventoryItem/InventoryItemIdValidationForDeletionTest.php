<?php

use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class InventoryItemIdValidationForDeletionTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        Parent::setUp();
        $admin = factory(User::class)->state('admin')->create();
        $this->actingAs($admin, 'api');
    }

    /**
     * Tests inventory item id not an integer rejection.
     *
     * @return void
     */
    public function testInventoryItemIdNotAnIntegerRejection()
    {
        $response = $this->json('DELETE', '/api/inventoryItems/string', []);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * Tests deletion of non-existent inventory item rejection.
     *
     * @return void
     */
    public function testDeletionOfNonExistentInventoryItemRejection()
    {
        $nonExistentInventoryItemID = factory(InventoryItem::class, 5)->create()->max('id') + 1;

        $response = $this->json('DELETE', route('inventoryItems.destroy', $nonExistentInventoryItemID), []);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * Tests deletion of currently borrowed inventory item rejection.
     *
     * @return void
     */
    public function testDeletionOfCurrentlyBorrowedInventoryItemRejection()
    {
        $inventoryItem = factory(InventoryItem::class)->state('borrowed')->create();
        $response = $this->json('DELETE', route('inventoryItems.destroy', $inventoryItem->id), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('inventoryItem');
    }

    /**
     * Tests deletion of correct inventory item validation.
     *
     * @return void
     */
    public function testDeletionOfCorrectInventoryItemValidation()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('DELETE', route('inventoryItems.destroy', $inventoryItem->id), []);
        $response->assertStatus(Response::HTTP_OK);
    }
}

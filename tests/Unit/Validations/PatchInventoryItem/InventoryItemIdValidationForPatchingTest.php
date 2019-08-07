<?php

use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class InventoryItemIdValidationForPatchingTest extends TestCase
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
        $response = $this->json('PATCH', '/api/inventoryItems/string', []);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * Tests patching of non-existent inventory item rejection.
     *
     * @return void
     */
    public function testPatchingOfNonExistentInventoryItemRejection()
    {
        $inventoryItems = factory(InventoryItem::class, 5)->create();
        $inventoryItemsIDs = [];
        foreach ($inventoryItems as $inventoryItem) array_push($inventoryItemsIDs, $inventoryItem->id);
        $nonExistentInventoryItemID = max($inventoryItemsIDs) + 1;

        $response = $this->json('PATCH', '/api/inventoryItems/' . $nonExistentInventoryItemID, []);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * Tests patching of correct inventory item validation.
     *
     * @return void
     */
    public function testPatchingOfCorrectInventoryItemValidation()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', '/api/inventoryItems/' . $inventoryItem->id, []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}

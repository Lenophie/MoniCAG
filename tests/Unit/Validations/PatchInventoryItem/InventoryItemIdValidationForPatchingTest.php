<?php

namespace Tests\Feature;

use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class InventoryItemIdValidationForPatchingTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp()
    {
        Parent::setUp();
        $admin = factory(User::class)->state('admin')->create();
        $this->actingAs($admin);
    }

    /**
     * Tests inventory item requirement.
     *
     * @return void
     */
    public function testInventoryItemRequirement()
    {
        $response = $this->json('PATCH', '/edit-inventory', []);
        $response->assertJsonValidationErrors('inventoryItemId');
    }

    /**
     * Tests inventory item id not an integer rejection.
     *
     * @return void
     */
    public function testInventoryItemIdNotAnIntegerRejection()
    {
        $response = $this->json('PATCH', '/edit-inventory', [
            'inventoryItemId' => 'I am a string'
        ]);
        $response->assertJsonValidationErrors('inventoryItemId');
        $response = $this->json('PATCH', '/edit-inventory', [
            'inventoryItemId' => null
        ]);
        $response->assertJsonValidationErrors('inventoryItemId');
        $response = $this->json('PATCH', '/edit-inventory', [
            'inventoryItemId' => []
        ]);
        $response->assertJsonValidationErrors('inventoryItemId');
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

        $response = $this->json('PATCH', '/edit-inventory', [
            'inventoryItemId' => $nonExistentInventoryItemID
        ]);
        $response->assertJsonValidationErrors('inventoryItemId');
    }

    /**
     * Tests patching of correct inventory item validation.
     *
     * @return void
     */
    public function testPatchingOfCorrectInventoryItemValidation()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', '/edit-inventory', [
            'inventoryItemId' => $inventoryItem->id
        ]);
        $response->assertJsonMissingValidationErrors('inventoryItemId');
    }
}

<?php

use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DeleteInventoryItemRequestTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp()
    {
        Parent::setUp();
        $admin = factory(User::class)->state('admin')->create();
        $this->actingAs($admin);
    }

    /**
     * Tests delete inventory item request.
     *
     * @return void
     */
    public function testDeleteInventoryItemRequest()
    {
        // Fields values setup
        $inventoryItems = factory(InventoryItem::class, 3)->create();
        $genresCollection = $inventoryItems[1]->genres()->get();
        $genres = [];
        foreach ($genresCollection as $genre) array_push($genres, $genre->id);

        // Delete inventory item
        $response = $this->json('DELETE', '/edit-inventory', [
            'inventoryItemId' => $inventoryItems[1]->id
        ]);

        // Check response
        $response->assertStatus(200);

        // Check inventory item deletion in database
        $this->assertDatabaseMissing('inventory_items', [
            'id' => $inventoryItems[1]->id
        ]);

        // Check inventory item genres relationships deletion
        foreach($genres as $genre) {
            $this->assertDatabaseMissing('genre_inventory_item', [
                'inventory_item_id' => $inventoryItems[1]->id,
                'genre_id' => $genre
            ]);
        }

        // Check other inventory items unaffected
        $this->assertDatabaseHas('inventory_items', [
            'id' => $inventoryItems[0]->id
        ]);
        $this->assertDatabaseHas('inventory_items', [
            'id' => $inventoryItems[2]->id
        ]);
    }
}

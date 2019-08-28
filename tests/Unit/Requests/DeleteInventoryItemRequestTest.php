<?php

use App\Borrowing;
use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class DeleteInventoryItemRequestTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        Parent::setUp();
        $admin = factory(User::class)->state('admin')->create();
        $this->actingAs($admin, 'api');
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
        $genres = $inventoryItems[1]->genres()->get()->pluck('id')->all();
        $altNames = $inventoryItems[1]->altNames()->get()->pluck('name')->all();

        // Delete inventory item
        $response = $this->json('DELETE', '/api/inventoryItems/' . $inventoryItems[1]->id, []);

        // Check response
        $response->assertStatus(Response::HTTP_OK);

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

        // Check inventory item alt names relationships deletion
        foreach($altNames as $altName) {
            $this->assertDatabaseMissing('inventory_item_alt_names', [
                'name' => $altName
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

    /**
     * Tests delete inventory item request borrowing cascading.
     *
     * @return void
     */
    public function testDeleteInventoryItemRequestBorrowingCascading()
    {
        // Fields values setup
        $inventoryItem = factory(InventoryItem::class)->create();
        $borrowingOfItem = factory(Borrowing::class)->create([
            'inventory_item_id' => $inventoryItem->id
        ]);
        // Delete inventory item
        $this->json('DELETE', '/api/inventoryItems/' . $inventoryItem->id, []);

        // Check cascading
        $this->assertDatabaseMissing('borrowings', [
            'id' => $borrowingOfItem->id
        ]);
    }
}

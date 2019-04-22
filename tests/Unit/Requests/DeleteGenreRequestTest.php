<?php

use App\Genre;
use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteGenreRequestTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    protected function setUp()
    {
        Parent::setUp();
        $this->faker->seed(0);
        $admin = factory(User::class)->state('admin')->create();
        $this->actingAs($admin, 'api');
    }

    /**
     * Tests delete genre request.
     *
     * @return void
     */
    public function testDeleteGenreRequest()
    {
        // Create some genres and attach them to an inventory item
        $genres = factory(Genre::class, 3)->create();
        $inventoryItem = factory(InventoryItem::class)->create();
        $inventoryItem->genres()->sync($genres->pluck('id'));

        // Delete genre
        $response = $this->json('DELETE', '/api/genres/' . $genres[1]->id, []);

        // Check response
        $response->assertStatus(200);

        // Check genre deletion in database
        $this->assertDatabaseMissing('genres', [
            'id' => $genres[1]->id
        ]);

        // Check other genres unaffected
        $this->assertDatabaseHas('genres', [
            'id' => $genres[0]->id
        ]);
        $this->assertDatabaseHas('genres', [
            'id' => $genres[2]->id
        ]);

        // Check Many to Many relationships
        $this->assertDatabaseHas('genre_inventory_item', [
            'inventory_item_id' => $inventoryItem->id,
            'genre_id' => $genres[0]->id
        ]);
        $this->assertDatabaseHas('genre_inventory_item', [
            'inventory_item_id' => $inventoryItem->id,
            'genre_id' => $genres[2]->id
        ]);
        $this->assertDatabaseMissing('genre_inventory_item', [
            'inventory_item_id' => $inventoryItem->id,
            'genre_id' => $genres[1]->id
        ]);
    }
}

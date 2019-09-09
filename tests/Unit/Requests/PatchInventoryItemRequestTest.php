<?php

use App\Genre;
use App\InventoryItem;
use App\InventoryItemStatus;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class PatchInventoryItemRequestTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    protected function setUp(): void
    {
        Parent::setUp();
        $this->faker->seed(0);
        $admin = factory(User::class)->state('admin')->create();
        $this->actingAs($admin, 'api');
    }

    /**
     * Tests patch inventory item request.
     *
     * @return void
     */
    public function testPatchInventoryItemRequest()
    {
        // Initial inventory item
        $inventoryItemToPatch = factory(InventoryItem::class)->create();
        $initialGenres = $inventoryItemToPatch->genres()->get()->pluck('id')->all();
        $initialAltNames = $inventoryItemToPatch->altNames()->get()->pluck('id')->all();

        // New data
        $durationMin = rand(1, 30);
        $durationMax = $durationMin + rand(1, 30);
        $playersMin = rand(1, 4);
        $playersMax = $playersMin + rand(1, 10);
        $name = $this->faker->unique()->word;
        $genres = factory(Genre::class, 5)->create()->pluck('id')->all();
        $altNames = [$this->faker->unique()->word, $this->faker->unique()->word];

        // Patch inventory item
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItemToPatch->id), [
            'durationMin' => $durationMin,
            'durationMax' => $durationMax,
            'playersMin' => $playersMin,
            'playersMax' => $playersMax,
            'genres' => $genres,
            'name' => $name,
            'altNames' => $altNames,
            'statusId' => InventoryItemStatus::IN_F2
        ]);

        // Check response
        $response->assertStatus(Response::HTTP_OK);

        // Check inventory item patching in database
        $this->assertDatabaseHas('inventory_items', [
            'id' => $inventoryItemToPatch->id,
            'duration_min' => $durationMin,
            'duration_max' => $durationMax,
            'players_min' => $playersMin,
            'players_max' => $playersMax,
            'name' => $name,
            'status_id' => InventoryItemStatus::IN_F2
        ]);

        // Check inventory item genres relationships update
        foreach($genres as $genre) {
            $this->assertDatabaseHas('genre_inventory_item', [
                'inventory_item_id' => $inventoryItemToPatch->id,
                'genre_id' => $genre
            ]);
        }

        // Check inventory item alt names relationships update
        foreach($altNames as $altName) {
            $this->assertDatabaseHas('inventory_item_alt_names', [
                'inventory_item_id' => $inventoryItemToPatch->id,
                'name' => $altName
            ]);
        }

        // Check previous genres relationships removal
        foreach($initialGenres as $genre) {
            $this->assertDatabaseMissing('genre_inventory_item', [
                'inventory_item_id' => $inventoryItemToPatch->id,
                'genre_id' => $genre
            ]);
        }

        // Check inventory item alt names relationships update
        foreach($initialAltNames as $altName) {
            $this->assertDatabaseMissing('inventory_item_alt_names', [
                'inventory_item_id' => $inventoryItemToPatch->id,
                'name' => $altName
            ]);
        }
    }
}

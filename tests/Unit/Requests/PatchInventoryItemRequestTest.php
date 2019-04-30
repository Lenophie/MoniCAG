<?php

use App\Genre;
use App\InventoryItem;
use App\InventoryItemStatus;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
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
        // Fields values setup
        $inventoryItemToPatch = factory(InventoryItem::class)->create();
        $initialGenresCollection = $inventoryItemToPatch->genres()->get();
        $initialGenres = [];
        foreach ($initialGenresCollection as $initialGenre) array_push($initialGenres, $initialGenre->id);
        $durationMin = rand(1, 30);
        $durationMax = $durationMin + rand(1, 30);
        $playersMin = rand(1, 4);
        $playersMax = $playersMin + rand(1, 10);
        $nameFr = $this->faker->unique()->word;
        $nameEn = $this->faker->unique()->word;
        $genresCollection = factory(Genre::class, 5)->create();
        $genres = [];
        foreach ($genresCollection as $genre) array_push($genres, $genre->id);

        // Patch inventory item
        $response = $this->json('PATCH', '/api/inventoryItems/' . $inventoryItemToPatch->id, [
            'durationMin' => $durationMin,
            'durationMax' => $durationMax,
            'playersMin' => $playersMin,
            'playersMax' => $playersMax,
            'genres' => $genres,
            'nameFr' => $nameFr,
            'nameEn' => $nameEn,
            'statusId' => InventoryItemStatus::IN_F2
        ]);

        // Check response
        $response->assertStatus(200);

        // Check inventory item patching in database
        $this->assertDatabaseHas('inventory_items', [
            'id' => $inventoryItemToPatch->id,
            'duration_min' => $durationMin,
            'duration_max' => $durationMax,
            'players_min' => $playersMin,
            'players_max' => $playersMax,
            'name_fr' => $nameFr,
            'name_en' => $nameEn,
            'status_id' => InventoryItemStatus::IN_F2
        ]);

        // Check inventory item genres relationships update
        foreach($genres as $genre) {
            $this->assertDatabaseHas('genre_inventory_item', [
                'inventory_item_id' => $inventoryItemToPatch->id,
                'genre_id' => $genre
            ]);
        }

        // Check previous genres relationships removal
        foreach($initialGenres as $genre) {
            $this->assertDatabaseMissing('genre_inventory_item', [
                'inventory_item_id' => $inventoryItemToPatch->id,
                'genre_id' => $genre
            ]);
        }
    }
}

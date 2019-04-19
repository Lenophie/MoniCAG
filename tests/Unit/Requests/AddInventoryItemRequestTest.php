<?php

use App\Genre;
use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddInventoryItemRequestTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    protected function setUp()
    {
        Parent::setUp();
        $this->faker->seed(0);
        $admin = factory(User::class)->state('admin')->create();
        $this->actingAs($admin);
    }

    /**
     * Tests add inventory item request.
     *
     * @return void
     */
    public function testAddInventoryItemRequest()
    {
        // Fields values setup
        $durationMin = rand(1, 30);
        $durationMax = $durationMin + rand(1, 30);
        $playersMin = rand(1, 4);
        $playersMax = $playersMin + rand(1, 10);
        $nameFr = $this->faker->unique()->word;
        $nameEn = $this->faker->unique()->word;
        $genresCollection = factory(Genre::class, 5)->create();
        $genres = [];
        foreach ($genresCollection as $genre) array_push($genres, $genre->id);

        // Create inventory item
        $response = $this->json('POST', '/edit-inventory', [
            'durationMin' => $durationMin,
            'durationMax' => $durationMax,
            'playersMin' => $playersMin,
            'playersMax' => $playersMax,
            'genres' => $genres,
            'nameFr' => $nameFr,
            'nameEn' => $nameEn
        ]);

        // Check response
        $response->assertStatus(200);

        // Check inventory item creation in database
        $this->assertDatabaseHas('inventory_items', [
            'duration_min' => $durationMin,
            'duration_max' => $durationMax,
            'players_min' => $playersMin,
            'players_max' => $playersMax,
            'name_fr' => $nameFr,
            'name_en' => $nameEn
        ]);

        // Check inventory item genres relationships creation
        $createdInventoryItemID = InventoryItem::where('name_fr', $nameFr)->first()->id;
        foreach($genres as $genre) {
            $this->assertDatabaseHas('genre_inventory_item', [
                'inventory_item_id' => $createdInventoryItemID,
                'genre_id' => $genre
            ]);
        }
    }
}

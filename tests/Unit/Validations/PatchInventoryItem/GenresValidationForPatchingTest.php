<?php

use App\Genre;
use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class GenresValidationForPatchingTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp()
    {
        Parent::setUp();
        $admin = factory(User::class)->state('admin')->create();
        $this->actingAs($admin, 'api');
    }

    /**
     * Tests genres requirement.
     *
     * @return void
     */
    public function testGenresRequirement()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', '/api/inventoryItems/' . $inventoryItem->id, []);
        $response->assertJsonValidationErrors('genres');
        $response = $this->json('PATCH', '/api/inventoryItems/' . $inventoryItem->id, [
            'genres' => []
        ]);
        $response->assertJsonValidationErrors('genres');
    }

    /**
     * Tests genres not an array rejection.
     *
     * @return void
     */
    public function testGenresNotAnArrayRejection()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', '/api/inventoryItems/' . $inventoryItem->id, [
            'genres' => 1
        ]);
        $response->assertJsonValidationErrors('genres');
        $response = $this->json('PATCH', '/api/inventoryItems/' . $inventoryItem->id, [
            'genres' => 'I am a string'
        ]);
        $response->assertJsonValidationErrors('genres');
        $response = $this->json('PATCH', '/api/inventoryItems/' . $inventoryItem->id, [
            'genres' => null
        ]);
        $response->assertJsonValidationErrors('genres');
    }

    /**
     * Tests genre value not an integer rejection.
     *
     * @return void
     */
    public function testGenreValueNotAnIntegerRejection()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', '/api/inventoryItems/' . $inventoryItem->id, [
            'genres' => ['I am a string']
        ]);
        $response->assertJsonValidationErrors('genres.0');
        $response = $this->json('PATCH', '/api/inventoryItems/' . $inventoryItem->id, [
            'genres' => [null]
        ]);
        $response->assertJsonValidationErrors('genres.0');
        $response = $this->json('PATCH', '/api/inventoryItems/' . $inventoryItem->id, [
            'genres' => [[0]]
        ]);
        $response->assertJsonValidationErrors('genres.0');
    }

    /**
     * Tests single genre validation.
     *
     * @return void
     */
    public function testSingleGenreValidation() {
        $inventoryItem = factory(InventoryItem::class)->create();
        $genre = factory(Genre::class)->create();
        $response = $this->json('PATCH', '/api/inventoryItems/' . $inventoryItem->id, [
            'genres' => [$genre->id]
        ]);
        $response->assertJsonMissingValidationErrors('genres.0');
    }

    /**
     * Tests multiple genres validation.
     *
     * @return void
     */
    public function testMultipleGenresValidation() {
        $inventoryItem = factory(InventoryItem::class)->create();
        $genres = factory(Genre::class, 5)->create();
        $genresIDs = [];
        foreach($genres as $genre) array_push($genresIDs, $genre->id);

        $response = $this->json('PATCH', '/api/inventoryItems/' . $inventoryItem->id, [
            'genres' => $genresIDs
        ]);
        for ($i = 0; $i < 5; $i++) $response->assertJsonMissingValidationErrors("genres.{$i}");
    }

    /**
     * Tests non-existent genre rejection.
     *
     * @return void
     */
    public function testNonExistentGenreRejection() {
        $inventoryItem = factory(InventoryItem::class)->create();
        $genres = factory(Genre::class, 5)->create();
        $genresIDs = [];
        foreach($genres as $genre) array_push($genresIDs, $genre->id);
        $nonExistentGenreID = max($genresIDs) + 1;

        $response = $this->json('PATCH', '/api/inventoryItems/' . $inventoryItem->id, [
            'genres' => [$nonExistentGenreID]
        ]);
        $response->assertJsonValidationErrors('genres.0');
    }

    /**
     * Tests duplicate genre rejection.
     *
     * @return void
     */
    public function testDuplicateGenreRejection() {
        $inventoryItem = factory(InventoryItem::class)->create();
        $genre = factory(Genre::class)->create();
        $response = $this->json('PATCH', '/api/inventoryItems/' . $inventoryItem->id, [
            'genres' => [$genre->id, $genre->id]
        ]);
        $response->assertJsonValidationErrors('genres.0');
    }
}

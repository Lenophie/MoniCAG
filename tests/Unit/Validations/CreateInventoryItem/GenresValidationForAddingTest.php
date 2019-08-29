<?php

use App\Genre;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class GenresValidationForAddingTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
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
        $response = $this->json('POST', '/api/inventoryItems', []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('genres');

        $response = $this->json('POST', '/api/inventoryItems', [
            'genres' => []
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('genres');
    }

    /**
     * Tests genres not an array rejection.
     *
     * @return void
     */
    public function testGenresNotAnArrayRejection()
    {
        $response = $this->json('POST', '/api/inventoryItems', [
            'genres' => 1
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('genres');

        $response = $this->json('POST', '/api/inventoryItems', [
            'genres' => 'I am a string'
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('genres');

        $response = $this->json('POST', '/api/inventoryItems', [
            'genres' => null
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('genres');
    }

    /**
     * Tests genre value not an integer rejection.
     *
     * @return void
     */
    public function testGenreValueNotAnIntegerRejection()
    {
        $response = $this->json('POST', '/api/inventoryItems', [
            'genres' => ['I am a string']
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('genres.0');

        $response = $this->json('POST', '/api/inventoryItems', [
            'genres' => [null]
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('genres.0');

        $response = $this->json('POST', '/api/inventoryItems', [
            'genres' => [[0]]
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('genres.0');
    }

    /**
     * Tests single genre validation.
     *
     * @return void
     */
    public function testSingleGenreValidation() {
        $genre = factory(Genre::class)->create();
        $response = $this->json('POST', '/api/inventoryItems', [
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
        $genres = factory(Genre::class, 5)->create();
        $genresIDs = [];
        foreach($genres as $genre) array_push($genresIDs, $genre->id);

        $response = $this->json('POST', '/api/inventoryItems', [
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
        $genres = factory(Genre::class, 5)->create();
        $genresIDs = [];
        foreach($genres as $genre) array_push($genresIDs, $genre->id);
        $nonExistentGenreID = max($genresIDs) + 1;

        $response = $this->json('POST', '/api/inventoryItems', [
            'genres' => [$nonExistentGenreID]
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('genres.0');
    }

    /**
     * Tests duplicate genre rejection.
     *
     * @return void
     */
    public function testDuplicateGenreRejection() {
        $genre = factory(Genre::class)->create();
        $response = $this->json('POST', '/api/inventoryItems', [
            'genres' => [$genre->id, $genre->id]
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('genres.0');
    }
}

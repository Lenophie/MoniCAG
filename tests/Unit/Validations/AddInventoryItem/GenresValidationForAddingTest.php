<?php

use App\Genre;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class GenresValidationForAddingTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp()
    {
        Parent::setUp();
        $admin = factory(User::class)->state('admin')->create();
        $this->actingAs($admin);
    }

    /**
     * Tests genres requirement.
     *
     * @return void
     */
    public function testGenresRequirement()
    {
        $response = $this->json('POST', '/edit-inventory', []);
        $response->assertJsonValidationErrors('genres');
        $response = $this->json('POST', '/edit-inventory', [
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
        $response = $this->json('POST', '/edit-inventory', [
            'genres' => 1
        ]);
        $response->assertJsonValidationErrors('genres');
        $response = $this->json('POST', '/edit-inventory', [
            'genres' => 'I am a string'
        ]);
        $response->assertJsonValidationErrors('genres');
        $response = $this->json('POST', '/edit-inventory', [
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
        $response = $this->json('POST', '/edit-inventory', [
            'genres' => ['I am a string']
        ]);
        $response->assertJsonValidationErrors('genres.0');
        $response = $this->json('POST', '/edit-inventory', [
            'genres' => [null]
        ]);
        $response->assertJsonValidationErrors('genres.0');
        $response = $this->json('POST', '/edit-inventory', [
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
        $genre = factory(Genre::class)->create();
        $response = $this->json('POST', '/edit-inventory', [
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

        $response = $this->json('POST', '/edit-inventory', [
            'genres' => $genresIDs
        ]);
        for ($i = 0; $i < 5; $i++) $response->assertJsonMissingValidationErrors('genres.' . $i);
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

        $response = $this->json('POST', '/edit-inventory', [
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
        $genre = factory(Genre::class)->create();
        $response = $this->json('POST', '/edit-inventory', [
            'genres' => [$genre->id, $genre->id]
        ]);
        $response->assertJsonValidationErrors('genres.0');
    }
}

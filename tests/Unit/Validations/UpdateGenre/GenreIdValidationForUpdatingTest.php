<?php

use App\Genre;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class GenreIdValidationForUpdatingGenreTest extends TestCase
{
    use DatabaseTransactions;

    private $admin;

    protected function setUp()
    {
        Parent::setUp();
        $admin = factory(User::class)->state('admin')->create();
        $this->actingAs($admin, 'api');
        $this->admin = $admin;
    }

    /**
     * Tests genre id not an integer rejection.
     *
     * @return void
     */
    public function testGenreIdNotAnIntegerRejection()
    {
        $response = $this->json('PATCH', '/api/genres/string', []);
        $response->assertStatus(404);
    }

    /**
     * Tests non existent genre rejection.
     *
     * @return void
     */
    public function testNonExistentGenreRejection()
    {
        $genres = factory(Genre::class, 5)->create();
        $genresIDs = [];
        foreach($genres as $genre) array_push($genresIDs, $genre->id);
        $nonExistentGenreID = max($genresIDs) + 1;

        $response = $this->json('PATCH', '/api/genres/' . $nonExistentGenreID, []);
        $response->assertStatus(404);
    }
}
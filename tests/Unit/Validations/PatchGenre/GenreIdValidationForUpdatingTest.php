<?php

use App\Genre;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class GenreIdValidationForUpdatingGenreTest extends TestCase
{
    use DatabaseTransactions;

    private $admin;

    protected function setUp(): void
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
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * Tests non existent genre rejection.
     *
     * @return void
     */
    public function testNonExistentGenreRejection()
    {
        $nonExistentGenreID = factory(Genre::class, 5)->create()->max('id') + 1;

        $response = $this->json('PATCH', route('genres.update', $nonExistentGenreID), []);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}

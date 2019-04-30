<?php

use App\Genre;
use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class GenreIdValidationForDeletionTest extends TestCase
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
        $response = $this->json('DELETE', '/api/genres/string', []);
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
        $genresIds = [];
        foreach($genres as $genre) array_push($genresIds, $genre->id);
        $nonExistentGenreID = max($genresIds) + 1;

        $response = $this->json('DELETE', '/api/genres/' . $nonExistentGenreID, []);
        $response->assertStatus(404);
    }

    /**
     * Tests genre rejection when only genre of an item
     *
     * @return void
     */
    public function testOnlyGenreOfItemRejection()
    {
        $genre = factory(Genre::class)->create();
        factory(InventoryItem::class)->create()->genres()->sync([$genre->id]);
        $response = $this->json('DELETE', '/api/genres/' . $genre->id, []);
        $response->assertStatus(422);
    }

    /**
     * Tests genre validation when genre of an item among others
     *
     * @return void
     */
    public function testGenreOfItemWithMultipleGenresValidation()
    {
        $genres = factory(Genre::class, 2)->create();
        factory(InventoryItem::class)->create()->genres()->sync($genres->pluck('id'));
        $response = $this->json('DELETE', '/api/genres/' . $genres[0]->id, []);
        $response->assertStatus(200);
    }

    /**
     * Tests genres validation when no game has genre
     *
     * @return void
     */
    public function testGenreWithNoitemValidation() {
        $genre = factory(Genre::class)->create();
        $response = $this->json('DELETE', '/api/genres/' . $genre->id, []);
        $response->assertStatus(200);
    }
}

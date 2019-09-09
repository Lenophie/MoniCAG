<?php

use App\Genre;
use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
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

        $response = $this->json('DELETE', route('genres.destroy', $nonExistentGenreID), []);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
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

        $response = $this->json('DELETE', route('genres.destroy', $genre->id), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
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

        $response = $this->json('DELETE', route('genres.destroy', $genres[0]->id), []);
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Tests genres validation when no game has genre
     *
     * @return void
     */
    public function testGenreWithNoItemValidation() {
        $genre = factory(Genre::class)->create();

        $response = $this->json('DELETE', route('genres.destroy', $genre->id), []);
        $response->assertStatus(Response::HTTP_OK);
    }
}

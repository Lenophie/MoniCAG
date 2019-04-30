<?php

use App\Genre;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateGenreRequestTest extends TestCase
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
     * Tests add genre request.
     *
     * @return void
     */
    public function testGenreRequest()
    {
        $genre = factory(Genre::class)->create();

        // Fields values setup
        $nameFr = $this->faker->unique()->word;
        $nameEn = $this->faker->unique()->word;

        // Create genre
        $response = $this->json('PATCH', '/api/genres/' . $genre->id, [
            'nameFr' => $nameFr,
            'nameEn' => $nameEn
        ]);

        // Check response
        $response->assertStatus(200);

        // Check inventory item creation in database
        $this->assertDatabaseHas('genres', [
            'id' => $genre->id,
            'name_fr' => $nameFr,
            'name_en' => $nameEn
        ]);
    }
}

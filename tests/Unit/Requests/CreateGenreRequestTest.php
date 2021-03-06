<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateGenreRequestTest extends TestCase
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
        // Fields values setup
        $nameFr = $this->faker->unique()->word;
        $nameEn = $this->faker->unique()->word;

        // Create genre
        $response = $this->json('POST', route('genres.store'), [
            'nameFr' => $nameFr,
            'nameEn' => $nameEn
        ]);

        // Check response
        $response->assertStatus(Response::HTTP_CREATED);

        // Check inventory item creation in database
        $this->assertDatabaseHas('genres', [
            'name_fr' => $nameFr,
            'name_en' => $nameEn
        ]);
    }
}

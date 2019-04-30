<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddGenreRequestTest extends TestCase
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
        $response = $this->json('POST', '/api/genres', [
            'nameFr' => $nameFr,
            'nameEn' => $nameEn
        ]);

        // Check response
        $response->assertStatus(201);

        // Check inventory item creation in database
        $this->assertDatabaseHas('genres', [
            'name_fr' => $nameFr,
            'name_en' => $nameEn
        ]);
    }
}

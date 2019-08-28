<?php

use App\Genre;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NamesValidationForUpdatingGenreTest extends TestCase
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
     * Tests names requirement.
     *
     * @return void
     */
    public function testNamesRequirement()
    {
        $genre = factory(Genre::class)->create();
        $response = $this->json('PATCH', '/api/genres/' . $genre->id, []);
        $response->assertJsonValidationErrors('nameFr');
        $response->assertJsonValidationErrors('nameEn');
    }

    /**
     * Tests names not strings rejection.
     *
     * @return void
     */
    public function testNamesNotStringsRejection()
    {
        $genre = factory(Genre::class)->create();
        $response = $this->json('PATCH', '/api/genres/' . $genre->id, [
            'nameFr' => ['I am a string'],
            'nameEn' => ['I am a string']
        ]);
        $response->assertJsonValidationErrors('nameFr');
        $response->assertJsonValidationErrors('nameEn');
        $response = $this->json('PATCH', '/api/genres/' . $genre->id, [
            'nameFr' => null,
            'nameEn' => null
        ]);
        $response->assertJsonValidationErrors('nameFr');
        $response->assertJsonValidationErrors('nameEn');
        $response = $this->json('PATCH', '/api/genres/' . $genre->id, [
            'nameFr' => 1,
            'nameEn' => 1
        ]);
        $response->assertJsonValidationErrors('nameFr');
        $response->assertJsonValidationErrors('nameEn');
    }

    /**
     * Tests names not uniques rejection.
     *
     * @return void
     */
    public function testNamesNotUniquesRejection()
    {
        $genres = factory(Genre::class, 3)->create();
        $response = $this->json('PATCH', '/api/genres/' . $genres[0]->id, [
            'nameFr' => $genres[1]->name_fr,
            'nameEn' => $genres[2]->name_en
        ]);
        $response->assertJsonValidationErrors('nameFr');
        $response->assertJsonValidationErrors('nameEn');
    }

    /**
     * Tests correct names validation.
     *
     * @return void
     */
    public function testCorrectNamesValidation()
    {
        $genre = factory(Genre::class)->create();
        $response = $this->json('PATCH', '/api/genres/' . $genre->id, [
            'nameFr' => $this->faker->unique()->word,
            'nameEn' => $this->faker->unique()->word
        ]);
        $response->assertJsonMissingValidationErrors('nameFr');
        $response->assertJsonMissingValidationErrors('nameEn');
    }

    /**
     * Tests same names validation.
     */
    public function testSameNamesValidation()
    {
        $genre = factory(Genre::class)->create();
        $response = $this->json('PATCH', '/api/genres/' . $genre->id, [
            'nameFr' => $genre->name_fr,
            'nameEn' => $genre->name_en
        ]);
        $response->assertJsonMissingValidationErrors('nameFr');
        $response->assertJsonMissingValidationErrors('nameEn');
    }
}

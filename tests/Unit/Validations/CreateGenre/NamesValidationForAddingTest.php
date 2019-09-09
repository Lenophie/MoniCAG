<?php

use App\Genre;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NamesValidationForAddingGenreTest extends TestCase
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
        $response = $this->json('POST', route('genres.store'), []);
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
        $response = $this->json('POST', route('genres.store'), [
            'nameFr' => ['I am a string'],
            'nameEn' => ['I am a string']
        ]);
        $response->assertJsonValidationErrors('nameFr');
        $response->assertJsonValidationErrors('nameEn');
        $response = $this->json('POST', route('genres.store'), [
            'nameFr' => null,
            'nameEn' => null
        ]);
        $response->assertJsonValidationErrors('nameFr');
        $response->assertJsonValidationErrors('nameEn');
        $response = $this->json('POST', route('genres.store'), [
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
        $genres = factory(Genre::class, 2)->create();
        $response = $this->json('POST', route('genres.store'), [
            'nameFr' => $genres[0]->name_fr,
            'nameEn' => $genres[1]->name_en
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
        $response = $this->json('POST', route('genres.store'), [
            'nameFr' => $this->faker->unique()->word,
            'nameEn' => $this->faker->unique()->word
        ]);
        $response->assertJsonMissingValidationErrors('nameFr');
        $response->assertJsonMissingValidationErrors('nameEn');
    }
}

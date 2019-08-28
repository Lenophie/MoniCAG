<?php

use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class AltNamesValidationForAddingTest extends TestCase
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
     * Tests alt names non-requirement.
     *
     * @return void
     */
    public function testAltNamesNonRequirement()
    {
        $response = $this->json('POST', '/api/inventoryItems', []);
        $response->assertJsonMissingValidationErrors('altNames');
    }

    /**
     * Tests alt names not an array rejection.
     *
     * @return void
     */
    public function testAltNamesNotAnArrayRejection()
    {
        $response = $this->json('POST', '/api/inventoryItems', [
            'altNames' => 'I am a string'
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('altNames');

        $response = $this->json('POST', '/api/inventoryItems', [
            'altNames' => 1,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('altNames');
    }

    /**
     * Tests alt name value not a string rejection.
     *
     * @return void
     */
    public function testAltNameValueNotAStringRejection()
    {
        $response = $this->json('POST', '/api/inventoryItems', [
            'altNames' => [0]
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('altNames.0');

        $response = $this->json('POST', '/api/inventoryItems', [
            'altNames' => [[]],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('altNames.0');

        $response = $this->json('POST', '/api/inventoryItems', [
            'altNames' => [null],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('altNames.0');
    }

    /**
     * Tests correct alt names validation.
     *
     * @return void
     */
    public function testCorrectAltNamesValidation()
    {
        $response = $this->json('POST', '/api/inventoryItems', [
            'altNames' => [$this->faker->unique()->word, $this->faker->unique()->word]
        ]);
        $response->assertJsonMissingValidationErrors('altNames');
        $response->assertJsonMissingValidationErrors('altNames.0');
        $response->assertJsonMissingValidationErrors('altNames.1');
    }
}

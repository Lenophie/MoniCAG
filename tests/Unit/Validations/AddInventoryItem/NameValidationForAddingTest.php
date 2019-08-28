<?php

use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class NameValidationForAddingTest extends TestCase
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
     * Tests name requirement.
     *
     * @return void
     */
    public function testNameRequirement()
    {
        $response = $this->json('POST', '/api/inventoryItems', []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');
    }

    /**
     * Tests name not string rejection.
     *
     * @return void
     */
    public function testNameNotStringRejection()
    {
        $response = $this->json('POST', '/api/inventoryItems', [
            'name' => ['I am a string']
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');

        $response = $this->json('POST', '/api/inventoryItems', [
            'name' => null
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');

        $response = $this->json('POST', '/api/inventoryItems', [
            'name' => 1,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');
    }

    /**
     * Tests name not unique rejection.
     *
     * @return void
     */
    public function testNameNotUniqueRejection()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('POST', '/api/inventoryItems', [
            'name' => $inventoryItem->name
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');
    }

    /**
     * Tests correct name validation.
     *
     * @return void
     */
    public function testCorrectNameValidation()
    {
        $response = $this->json('POST', '/api/inventoryItems', [
            'name' => $this->faker->unique()->word
        ]);
        $response->assertJsonMissingValidationErrors('name');
    }
}

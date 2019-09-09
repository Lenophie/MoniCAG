<?php

use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class NameValidationForPatchingTest extends TestCase
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
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), []);
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
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'name' => ['I am a string']
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'name' => null
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'name' => 1
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');
    }

    /**
     * Tests names not uniques rejection.
     *
     * @return void
     */
    public function testNamesNotUniquesRejection()
    {
        $inventoryItems = factory(InventoryItem::class, 2)->create();
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItems[0]->id), [
            'name' => $inventoryItems[1]->name
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');
    }

    /**
     * Tests name change during borrowing rejection.
     *
     * @return void
     */
    public function testNamesChangedDuringBorrowingRejection()
    {
        $inventoryItem = factory(InventoryItem::class)->state('borrowed')->create();
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'name' => $this->faker->unique()->word,
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
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'name' => $this->faker->unique()->word
        ]);
        $response->assertJsonMissingValidationErrors('name');
    }

    /**
     * Tests same names validation.
     *
     * @return void
     */
    public function testSameNameValidation()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'name' => $inventoryItem->name,
        ]);
        $response->assertJsonMissingValidationErrors('name');
    }

    /**
     * Tests same name during borrowing validation.
     *
     * @return void
     */
    public function testSameNameDuringBorrowingValidation()
    {
        $inventoryItem = factory(InventoryItem::class)->state('borrowed')->create();
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'name' => $inventoryItem->name
        ]);
        $response->assertJsonMissingValidationErrors('name');
    }
}

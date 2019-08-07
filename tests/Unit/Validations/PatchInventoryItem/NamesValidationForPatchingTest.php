<?php

use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class NamesValidationForPatchingTest extends TestCase
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
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', '/api/inventoryItems/' . $inventoryItem->id, []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
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
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', '/api/inventoryItems/' . $inventoryItem->id, [
            'nameFr' => ['I am a string'],
            'nameEn' => ['I am a string']
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('nameFr');
        $response->assertJsonValidationErrors('nameEn');
        $response = $this->json('PATCH', '/api/inventoryItems/' . $inventoryItem->id, [
            'nameFr' => null,
            'nameEn' => null
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('nameFr');
        $response->assertJsonValidationErrors('nameEn');
        $response = $this->json('PATCH', '/api/inventoryItems/' . $inventoryItem->id, [
            'nameFr' => 1,
            'nameEn' => 1
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
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
        $inventoryItems = factory(InventoryItem::class, 3)->create();
        $response = $this->json('PATCH', '/api/inventoryItems/' . $inventoryItems[2]->id, [
            'nameFr' => $inventoryItems[0]->name_fr,
            'nameEn' => $inventoryItems[1]->name_en
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('nameFr');
        $response->assertJsonValidationErrors('nameEn');
    }

    /**
     * Tests names change during borrowing rejection.
     *
     * @return void
     */
    public function testNamesChangedDuringBorrowingRejecion()
    {
        $inventoryItem = factory(InventoryItem::class)->state('borrowed')->create();
        $response = $this->json('PATCH', '/api/inventoryItems/' . $inventoryItem->id, [
            'nameFr' => $this->faker->unique()->word,
            'nameEn' => $this->faker->unique()->word
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
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
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', '/api/inventoryItems/' . $inventoryItem->id, [
            'nameFr' => $this->faker->unique()->word,
            'nameEn' => $this->faker->unique()->word
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonMissingValidationErrors('nameFr');
        $response->assertJsonMissingValidationErrors('nameEn');
    }

    /**
     * Tests same names validation.
     *
     * @return void
     */
    public function testSameNamesValidation()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', '/api/inventoryItems/' . $inventoryItem->id, [
            'nameFr' => $inventoryItem->name_fr,
            'nameEn' => $inventoryItem->name_en
        ]);
        $response->assertJsonMissingValidationErrors('nameFr');
        $response->assertJsonMissingValidationErrors('nameEn');
    }

    /**
     * Tests same names during borrowing validation.
     *
     * @return void
     */
    public function testSameNamesDuringBorrowingValidation()
    {
        $inventoryItem = factory(InventoryItem::class)->state('borrowed')->create();
        $response = $this->json('PATCH', '/api/inventoryItems/' . $inventoryItem->id, [
            'nameFr' => $inventoryItem->name_fr,
            'nameEn' => $inventoryItem->name_en
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonMissingValidationErrors('nameFr');
        $response->assertJsonMissingValidationErrors('nameEn');
    }
}

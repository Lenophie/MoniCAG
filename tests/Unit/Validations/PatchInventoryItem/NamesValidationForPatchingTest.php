<?php

namespace Tests\Feature;

use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NamesValidationForPatchingTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    protected function setUp()
    {
        Parent::setUp();
        $admin = factory(User::class)->state('admin')->create();
        $this->actingAs($admin);
        $this->faker->seed(0);
    }

    /**
     * Tests names requirement validation.
     *
     * @return void
     */
    public function testNamesRequirement()
    {
        $response = $this->json('PATCH', '/edit-inventory', []);
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
        $response = $this->json('PATCH', '/edit-inventory', [
            'nameFr' => ['I am a string'],
            'nameEn' => ['I am a string']
        ]);
        $response->assertJsonValidationErrors('nameFr');
        $response->assertJsonValidationErrors('nameEn');
        $response = $this->json('PATCH', '/edit-inventory', [
            'nameFr' => null,
            'nameEn' => null
        ]);
        $response->assertJsonValidationErrors('nameFr');
        $response->assertJsonValidationErrors('nameEn');
        $response = $this->json('PATCH', '/edit-inventory', [
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
        $inventoryItems = factory(InventoryItem::class, 2)->create();
        $response = $this->json('PATCH', '/edit-inventory', [
            'nameFr' => $inventoryItems[0]->name_fr,
            'nameEn' => $inventoryItems[1]->name_en
        ]);
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
        $patchedInventoryItem = factory(InventoryItem::class)->state('borrowed')->create();
        $response = $this->json('PATCH', '/edit-inventory', [
            'inventoryItemId' => $patchedInventoryItem->id,
            'nameFr' => $this->faker->unique()->word,
            'nameEn' => $this->faker->unique()->word
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
        $patchedInventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', '/edit-inventory', [
            'inventoryItemId' => $patchedInventoryItem->id,
            'nameFr' => $this->faker->unique()->word,
            'nameEn' => $this->faker->unique()->word
        ]);
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
        $patchedInventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', '/edit-inventory', [
            'inventoryItemId' => $patchedInventoryItem->id,
            'nameFr' => $patchedInventoryItem->name_fr,
            'nameEn' => $patchedInventoryItem->name_en
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
        $patchedInventoryItem = factory(InventoryItem::class)->state('borrowed')->create();
        $response = $this->json('PATCH', '/edit-inventory', [
            'inventoryItemId' => $patchedInventoryItem->id,
            'nameFr' => $patchedInventoryItem->name_fr,
            'nameEn' => $patchedInventoryItem->name_en
        ]);
        $response->assertJsonMissingValidationErrors('nameFr');
        $response->assertJsonMissingValidationErrors('nameEn');
    }
}

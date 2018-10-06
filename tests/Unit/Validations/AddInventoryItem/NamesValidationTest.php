<?php

namespace Tests\Feature;

use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NamesValidationTest extends TestCase
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
        $response = $this->json('POST', '/edit-inventory', []);
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
        $response = $this->json('POST', '/edit-inventory', [
            'nameFr' => ['I am a string'],
            'nameEn' => ['I am a string']
        ]);
        $response->assertJsonValidationErrors('nameFr');
        $response->assertJsonValidationErrors('nameEn');
        $response = $this->json('POST', '/edit-inventory', [
            'nameFr' => null,
            'nameEn' => null
        ]);
        $response->assertJsonValidationErrors('nameFr');
        $response->assertJsonValidationErrors('nameEn');
        $response = $this->json('POST', '/edit-inventory', [
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
        $response = $this->json('POST', '/edit-inventory', [
            'nameFr' => $inventoryItems[0]->name_fr,
            'nameEn' => $inventoryItems[1]->name_en
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
        $response = $this->json('POST', '/edit-inventory', [
            'nameFr' => $this->faker->unique()->word,
            'nameEn' => $this->faker->unique()->word
        ]);
        $response->assertJsonMissingValidationErrors('nameFr');
        $response->assertJsonMissingValidationErrors('nameEn');
    }
}

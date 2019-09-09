<?php

use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DurationsValidationForPatchingTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        Parent::setUp();
        $admin = factory(User::class)->state('admin')->create();
        $this->actingAs($admin, 'api');
    }

    /**
     * Tests durations nullability.
     *
     * @return void
     */
    public function testDurationsNullability()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'durationMin' => null,
            'durationMax' => null
        ]);
        $response->assertJsonMissingValidationErrors('durationMin');
        $response->assertJsonMissingValidationErrors('durationMax');
    }

    /**
     * Tests durations not integers rejection.
     *
     * @return void
     */
    public function testDurationsNotIntegersRejection()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'durationMin' => 'I am a string',
            'durationMax' => 'I am a string'
        ]);
        $response->assertJsonValidationErrors('durationMin');
        $response->assertJsonValidationErrors('durationMax');
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'durationMin' => [],
            'durationMax' => []
        ]);
        $response->assertJsonValidationErrors('durationMin');
        $response->assertJsonValidationErrors('durationMax');
    }

    /**
     * Tests durations not integers rejection.
     *
     * @return void
     */
    public function testDurationsInferiorToZeroRejection()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'durationMin' => -1,
            'durationMax' => -1
        ]);
        $response->assertJsonValidationErrors('durationMin');
        $response->assertJsonValidationErrors('durationMax');
    }

    /**
     * Tests max duration inferior to min duration rejection.
     *
     * @return void
     */
    public function testMaxDurationInferiorToMinDurationRejection()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'durationMin' => 20,
            'durationMax' => 5
        ]);
        $response->assertJsonValidationErrors('durationMax');
    }

    /**
     * Tests single duration filling validation.
     *
     * @return void
     */
    public function testSingleDurationFillingValidation()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'durationMin' => 5
        ]);
        $response->assertJsonMissingValidationErrors('durationMin');
        $response->assertJsonMissingValidationErrors('durationMax');
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'durationMax' => 5
        ]);
        $response->assertJsonMissingValidationErrors('durationMin');
        $response->assertJsonMissingValidationErrors('durationMax');
    }

    /**
     * Tests correct durations validation.
     *
     * @return void
     */
    public function testCorrectDurationsValidation()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'durationMin' => 5,
            'durationMax' => 20
        ]);
        $response->assertJsonMissingValidationErrors('durationMin');
        $response->assertJsonMissingValidationErrors('durationMax');
    }
}

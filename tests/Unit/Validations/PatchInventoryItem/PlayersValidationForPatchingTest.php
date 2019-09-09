<?php

use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PlayersValidationForPatchingTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        Parent::setUp();
        $admin = factory(User::class)->state('admin')->create();
        $this->actingAs($admin, 'api');
    }

    /**
     * Tests players counts nullability.
     *
     * @return void
     */
    public function testPlayersCountsNullability()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'playersMin' => null,
            'playersMax' => null
        ]);
        $response->assertJsonMissingValidationErrors('playersMin');
        $response->assertJsonMissingValidationErrors('playersMax');
    }

    /**
     * Tests players counts not integers rejection.
     *
     * @return void
     */
    public function testPlayersCountsNotIntegersRejection()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'playersMin' => 'I am a string',
            'playersMax' => 'I am a string'
        ]);
        $response->assertJsonValidationErrors('playersMin');
        $response->assertJsonValidationErrors('playersMax');
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'playersMin' => [],
            'playersMax' => []
        ]);
        $response->assertJsonValidationErrors('playersMin');
        $response->assertJsonValidationErrors('playersMax');
    }

    /**
     * Tests players counts not integers rejection.
     *
     * @return void
     */
    public function testPlayersCountsInferiorToZeroRejection()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'playersMin' => -1,
            'playersMax' => -1
        ]);
        $response->assertJsonValidationErrors('playersMin');
        $response->assertJsonValidationErrors('playersMax');
    }

    /**
     * Tests max players count inferior to min players count rejection.
     *
     * @return void
     */
    public function testMaxPlayersCountInferiorToMinPlayersCountRejection()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'playersMin' => 20,
            'playersMax' => 5
        ]);
        $response->assertJsonValidationErrors('playersMax');
    }

    /**
     * Tests single players count filling validation.
     *
     * @return void
     */
    public function testSinglePlayersCountFillingValidation()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'playersMin' => 5
        ]);
        $response->assertJsonMissingValidationErrors('playersMin');
        $response->assertJsonMissingValidationErrors('playersMax');
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'playersMax' => 5
        ]);
        $response->assertJsonMissingValidationErrors('playersMin');
        $response->assertJsonMissingValidationErrors('playersMax');
    }

    /**
     * Tests correct players counts validation.
     *
     * @return void
     */
    public function testCorrectPlayersCountsValidation()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'playersMin' => 5,
            'playersMax' => 20
        ]);
        $response->assertJsonMissingValidationErrors('playersMin');
        $response->assertJsonMissingValidationErrors('playersMax');
    }
}

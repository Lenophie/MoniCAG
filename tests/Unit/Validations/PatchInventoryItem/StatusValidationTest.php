<?php

use App\InventoryItem;
use App\InventoryItemStatus;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class StatusValidationTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        Parent::setUp();
        $admin = factory(User::class)->state('admin')->create();
        $this->actingAs($admin, 'api');
    }

    /**
     * Tests status requirement.
     *
     * @return void
     */
    public function testStatusRequirement()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), []);
        $response->assertJsonValidationErrors('statusId');
    }

    /**
     * Tests status not integer rejection.
     *
     * @return void
     */
    public function testStatusNotIntegerRejection()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'statusId' => []
        ]);
        $response->assertJsonValidationErrors('statusId');
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'statusId' => null
        ]);
        $response->assertJsonValidationErrors('statusId');
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'statusId' => 'I am a string'
        ]);
        $response->assertJsonValidationErrors('statusId');
    }

    /**
     * Tests incorrect status rejection.
     *
     * @return void
     */
    public function testIncorrectStatusRejection()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'statusId' => 200
        ]);
        $response->assertJsonValidationErrors('statusId');
    }

    /**
     * Tests status change during borrowing rejection.
     *
     * @return void
     */
    public function testStatusChangedDuringBorrowingRejecion()
    {
        $inventoryItem = factory(InventoryItem::class)->state('borrowed')->create();
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'statusId' => InventoryItemStatus::IN_LCR_D4
        ]);
        $response->assertJsonValidationErrors('statusId');
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'statusId' => InventoryItemStatus::IN_F2
        ]);
        $response->assertJsonValidationErrors('statusId');
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'statusId' => InventoryItemStatus::LOST
        ]);
        $response->assertJsonValidationErrors('statusId');
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'statusId' => InventoryItemStatus::UNKNOWN
        ]);
        $response->assertJsonValidationErrors('statusId');
    }

    /**
     * Tests same status during borrowing validation.
     *
     * @return void
     */
    public function testSameStatusDuringBorrowingValidation()
    {
        $inventoryItem = factory(InventoryItem::class)->state('borrowed')->create();
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'statusId' => InventoryItemStatus::BORROWED
        ]);
        $response->assertJsonMissingValidationErrors('statusId');
    }

    /**
     * Tests correct status change validation.
     *
     * @return void
     */
    public function testCorrectStatusChangeValidation()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'statusId' => InventoryItemStatus::IN_LCR_D4
        ]);
        $response->assertJsonMissingValidationErrors('statusId');
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'statusId' => InventoryItemStatus::IN_F2
        ]);
        $response->assertJsonMissingValidationErrors('statusId');
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'statusId' => InventoryItemStatus::LOST
        ]);
        $response->assertJsonMissingValidationErrors('statusId');
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'statusId' => InventoryItemStatus::UNKNOWN
        ]);
        $response->assertJsonMissingValidationErrors('statusId');
    }

    /**
     * Tests status change to borrowed rejection.
     *
     * @return void
     */
    public function testStatusChangeToBorrowedRejection()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), [
            'statusId' => InventoryItemStatus::BORROWED
        ]);
        $response->assertJsonValidationErrors('statusId');
    }
}

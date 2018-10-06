<?php

namespace Tests\Feature;

use App\InventoryItem;
use App\InventoryItemStatus;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class StatusValidationTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp()
    {
        Parent::setUp();
        $admin = factory(User::class)->state('admin')->create();
        $this->actingAs($admin);
    }

    /**
     * Tests status requirement.
     *
     * @return void
     */
    public function testStatusRequirement()
    {
        $response = $this->json('PATCH', '/edit-inventory', []);
        $response->assertJsonValidationErrors('statusId');
    }

    /**
     * Tests status not integer rejection.
     *
     * @return void
     */
    public function testStatusNotIntegerRejection()
    {
        $response = $this->json('PATCH', '/edit-inventory', [
            'statusId' => []
        ]);
        $response->assertJsonValidationErrors('statusId');
        $response = $this->json('PATCH', '/edit-inventory', [
            'statusId' => null
        ]);
        $response->assertJsonValidationErrors('statusId');
        $response = $this->json('PATCH', '/edit-inventory', [
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
        $response = $this->json('PATCH', '/edit-inventory', [
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
        $patchedInventoryItem = factory(InventoryItem::class)->state('borrowed')->create();
        $response = $this->json('PATCH', '/edit-inventory', [
            'inventoryItemId' => $patchedInventoryItem->id,
            'statusId' => InventoryItemStatus::IN_LCR_D4
        ]);
        $response->assertJsonValidationErrors('statusId');
        $response = $this->json('PATCH', '/edit-inventory', [
            'inventoryItemId' => $patchedInventoryItem->id,
            'statusId' => InventoryItemStatus::IN_F2
        ]);
        $response->assertJsonValidationErrors('statusId');
        $response = $this->json('PATCH', '/edit-inventory', [
            'inventoryItemId' => $patchedInventoryItem->id,
            'statusId' => InventoryItemStatus::LOST
        ]);
        $response->assertJsonValidationErrors('statusId');
        $response = $this->json('PATCH', '/edit-inventory', [
            'inventoryItemId' => $patchedInventoryItem->id,
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
        $patchedInventoryItem = factory(InventoryItem::class)->state('borrowed')->create();
        $response = $this->json('PATCH', '/edit-inventory', [
            'inventoryItemId' => $patchedInventoryItem->id,
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
        $patchedInventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', '/edit-inventory', [
            'inventoryItemId' => $patchedInventoryItem->id,
            'statusId' => InventoryItemStatus::IN_LCR_D4
        ]);
        $response->assertJsonMissingValidationErrors('statusId');
        $response = $this->json('PATCH', '/edit-inventory', [
            'inventoryItemId' => $patchedInventoryItem->id,
            'statusId' => InventoryItemStatus::IN_F2
        ]);
        $response->assertJsonMissingValidationErrors('statusId');
        $response = $this->json('PATCH', '/edit-inventory', [
            'inventoryItemId' => $patchedInventoryItem->id,
            'statusId' => InventoryItemStatus::LOST
        ]);
        $response->assertJsonMissingValidationErrors('statusId');
        $response = $this->json('PATCH', '/edit-inventory', [
            'inventoryItemId' => $patchedInventoryItem->id,
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
        $patchedInventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', '/edit-inventory', [
            'inventoryItemId' => $patchedInventoryItem->id,
            'statusId' => InventoryItemStatus::BORROWED
        ]);
        $response->assertJsonValidationErrors('statusId');
    }
}

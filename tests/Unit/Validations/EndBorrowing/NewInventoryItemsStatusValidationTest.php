<?php

use App\InventoryItemStatus;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class NewInventoryItemsStatusValidationTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp()
    {
        Parent::setUp();
        $lender = factory(User::class)->state('lender')->create();
        $this->actingAs($lender, 'api');
    }

    /**
     * Tests new inventory item status requirement.
     *
     * @return void
     */
    public function testNewInventoryItemsStatusRequirement()
    {
        $response = $this->json('PATCH', '/api/borrowings', []);
        $response->assertJsonValidationErrors('newInventoryItemsStatus');
    }

    /**
     * Tests new inventory item status not an integer rejection.
     *
     * @return void
     */
    public function testNewInventoryItemsStatusNotAnIntegerRejection()
    {
        $response = $this->json('PATCH', '/api/borrowings', [
            'newInventoryItemsStatus' => []
        ]);
        $response->assertJsonValidationErrors('newInventoryItemsStatus');
        $response = $this->json('PATCH', '/api/borrowings', [
            'newInventoryItemsStatus' => 'I am a string'
        ]);
        $response->assertJsonValidationErrors('newInventoryItemsStatus');
        $response = $this->json('PATCH', '/api/borrowings', [
            'newInventoryItemsStatus' => null
        ]);
        $response->assertJsonValidationErrors('newInventoryItemsStatus');
    }

    /**
     * Tests forbidden new inventory items status rejection.
     *
     * @return void
     */
    public function testForbiddenNewInventoryItemsStatusRejection() {
        $response = $this->json('PATCH', '/api/borrowings', [
            'newInventoryItemsStatus' => InventoryItemStatus::BORROWED
        ]);
        $response->assertJsonValidationErrors('newInventoryItemsStatus');
        $response = $this->json('PATCH', '/api/borrowings', [
            'newInventoryItemsStatus' => InventoryItemStatus::IN_F2
        ]);
        $response->assertJsonValidationErrors('newInventoryItemsStatus');
        $response = $this->json('PATCH', '/api/borrowings', [
            'newInventoryItemsStatus' => InventoryItemStatus::UNKNOWN
        ]);
        $response->assertJsonValidationErrors('newInventoryItemsStatus');
    }

    /**
     * Tests correct new inventory items status validation.
     *
     * @return void
     */
    public function testCorrectNewInventoryItemsStatusction() {
        $response = $this->json('PATCH', '/api/borrowings', [
            'newInventoryItemsStatus' => InventoryItemStatus::IN_LCR_D4
        ]);
        $response->assertJsonMissingValidationErrors('newInventoryItemsStatus');
        $response = $this->json('PATCH', '/api/borrowings', [
            'newInventoryItemsStatus' => InventoryItemStatus::LOST
        ]);
        $response->assertJsonMissingValidationErrors('newInventoryItemsStatus');
    }
}

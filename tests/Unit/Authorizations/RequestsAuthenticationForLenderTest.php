<?php

use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RequestsAuthenticationForLenderTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp()
    {
        Parent::setUp();
        $lender = factory(User::class)->state('lender')->create();
        $this->actingAs($lender, 'api');
    }

    /**
     * Tests lender allowed to post a new borrowing.
     *
     * @return void
     */
    public function testNewBorrowingRequestAllowedForLender()
    {
        $response = $this->json('POST', '/api/borrowings', []);
        $response->assertStatus(422);
    }

    /**
     * Tests lender allowed to end a borrowing.
     *
     * @return void
     */
    public function testEndBorrowingRequestAllowedForLender()
    {
        $response = $this->json('PATCH', '/api/borrowings', []);
        $response->assertStatus(422);
    }

    /**
     * Tests lender prevented from adding a new inventory item.
     *
     * @return void
     */
    public function testNoAddInventoryItemRequestAllowedForLender()
    {
        $response = $this->json('POST', '/api/inventoryItems', []);
        $response->assertStatus(403);
    }

    /**
     * Tests lender prevented from deleting an inventory item.
     *
     * @return void
     */
    public function testNoDeleteInventoryItemRequestAllowedForLender()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('DELETE', '/api/inventoryItems/' . $inventoryItem->id, []);
        $response->assertStatus(403);
    }

    /**
     * Tests lender prevented from patching an inventory item.
     *
     * @return void
     */
    public function testNoPatchInventoryItemRequestAllowedForLender()
    {
        $response = $this->json('PATCH', '/edit-inventory', []);
        $response->assertStatus(403);
    }

    /**
     * Tests lender prevented from patching a user.
     *
     * @return void
     */
    public function testNoPatchUserRequestAllowedForLender()
    {
        $response = $this->json('PATCH', '/edit-users', []);
        $response->assertStatus(403);
    }

    /**
     * Tests lender prevented from deleting a user.
     *
     * @return void
     */
    public function testNoDeleteUserRequestAllowedForLender()
    {
        $response = $this->json('DELETE', '/edit-users', []);
        $response->assertStatus(403);
    }
}

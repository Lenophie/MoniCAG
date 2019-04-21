<?php

use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RequestsAuthenticationForUserTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp()
    {
        Parent::setUp();
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');
    }

    /**
     * Tests basic user prevented from posting a new borrowing.
     *
     * @return void
     */
    public function testNoNewBorrowingRequestAllowedForUser()
    {
        $response = $this->json('POST', '/api/borrowings', []);
        $response->assertStatus(403);
    }

    /**
     * Tests basic user prevented from ending a borrowing.
     *
     * @return void
     */
    public function testNoEndBorrowingRequestAllowedForUser()
    {
        $response = $this->json('PATCH', '/api/borrowings', []);
        $response->assertStatus(403);
    }

    /**
     * Tests basic user prevented from adding a new inventory item.
     *
     * @return void
     */
    public function testNoAddInventoryItemRequestAllowedForUser()
    {
        $response = $this->json('POST', '/api/inventoryItems', []);
        $response->assertStatus(403);
    }

    /**
     * Tests basic user prevented from deleting an inventory item.
     *
     * @return void
     */
    public function testNoDeleteInventoryItemRequestAllowedForUser()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('DELETE', '/api/inventoryItems/' . $inventoryItem->id, []);
        $response->assertStatus(403);
    }

    /**
     * Tests basic user prevented from patching an inventory item.
     *
     * @return void
     */
    public function testNoPatchInventoryItemRequestAllowedForUser()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', '/api/inventoryItems/' . $inventoryItem->id, []);
        $response->assertStatus(403);
    }

    /**
     * Tests basic user prevented from patching a user.
     *
     * @return void
     */
    public function testNoPatchUserRequestAllowedForUser()
    {
        $user = factory(User::class)->create();
        $response = $this->json('PATCH', '/api/users/' . $user->id . '/role', []);
        $response->assertStatus(403);
    }

    /**
     * Tests basic user prevented from deleting a user.
     *
     * @return void
     */
    public function testNoDeleteUserRequestAllowedForUser()
    {
        $user = factory(User::class)->create();
        $response = $this->json('DELETE', '/api/users/' . $user->id, []);
        $response->assertStatus(403);
    }
}

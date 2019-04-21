<?php

use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RequestsAuthenticationForAdminTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp()
    {
        Parent::setUp();
        $admin = factory(User::class)->state('admin')->create();
        $this->actingAs($admin, 'api');
    }

    /**
     * Tests admin allowed to post a new borrowing.
     *
     * @return void
     */
    public function testNewBorrowingRequestAllowedForAdmin()
    {
        $response = $this->json('POST', '/api/borrowings', []);
        $response->assertStatus(422);
    }

    /**
     * Tests admin allowed to end a borrowing.
     *
     * @return void
     */
    public function testEndBorrowingRequestAllowedForAdmin()
    {
        $response = $this->json('PATCH', '/api/borrowings', []);
        $response->assertStatus(422);
    }

    /**
     * Tests admin allowed to add a new inventory item.
     *
     * @return void
     */
    public function testAddInventoryItemRequestAllowedForAdmin()
    {
        $response = $this->json('POST', '/edit-inventory', []);
        $response->assertStatus(422);
    }

    /**
     * Tests admin allowed to delete an inventory item.
     *
     * @return void
     */
    public function testDeleteInventoryItemRequestAllowedForAdmin()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('DELETE', '/api/inventoryItems/' . $inventoryItem->id, []);
        $response->assertStatus(200);
    }

    /**
     * Tests admin allowed to patch an inventory item.
     *
     * @return void
     */
    public function testPatchInventoryItemRequestAllowedForAdmin()
    {
        $response = $this->json('PATCH', '/edit-inventory', []);
        $response->assertStatus(422);
    }

    /**
     * Tests admin allowed to patch a user.
     *
     * @return void
     */
    public function testPatchUserRequestAllowedForAdmin()
    {
        $response = $this->json('PATCH', '/edit-users', []);
        $response->assertStatus(422);
    }

    /**
     * Tests admin allowed to delete a user.
     *
     * @return void
     */
    public function testDeleteUserRequestAllowedForAdmin()
    {
        $response = $this->json('DELETE', '/edit-users', []);
        $response->assertStatus(422);
    }
}

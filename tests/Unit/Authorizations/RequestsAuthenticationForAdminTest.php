<?php

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
        $this->actingAs($admin);
    }

    /**
     * Tests admin allowed to post a new borrowing.
     *
     * @return void
     */
    public function testNewBorrowingRequestAllowedForAdmin()
    {
        $response = $this->json('POST', '/new-borrowing', []);
        $response->assertStatus(422);
    }

    /**
     * Tests admin allowed to end a borrowing.
     *
     * @return void
     */
    public function testEndBorrowingRequestAllowedForAdmin()
    {
        $response = $this->json('PATCH', '/end-borrowing', []);
        $response->assertStatus(422);
    }

    /**
     * Tests admin prevented from adding a new inventory item.
     *
     * @return void
     */
    public function testNoAddInventoryItemRequestAllowedForAdmin()
    {
        $response = $this->json('POST', '/edit-inventory', []);
        $response->assertStatus(422);
    }

    /**
     * Tests admin prevented from deleting an inventory item.
     *
     * @return void
     */
    public function testNoDeleteInventoryItemRequestAllowedForAdmin()
    {
        $response = $this->json('DELETE', '/edit-inventory', []);
        $response->assertStatus(422);
    }

    /**
     * Tests admin prevented from patching an inventory item.
     *
     * @return void
     */
    public function testNoPatchInventoryItemRequestAllowedForAdmin()
    {
        $response = $this->json('PATCH', '/edit-inventory', []);
        $response->assertStatus(422);
    }

    /**
     * Tests admin prevented from patching a user.
     *
     * @return void
     */
    public function testNoPatchUserRequestAllowedForAdmin()
    {
        $response = $this->json('PATCH', '/edit-users', []);
        $response->assertStatus(422);
    }

    /**
     * Tests admin prevented from deleting a user.
     *
     * @return void
     */
    public function testNoDeleteUserRequestAllowedForAdmin()
    {
        $response = $this->json('DELETE', '/edit-users', []);
        $response->assertStatus(422);
    }
}

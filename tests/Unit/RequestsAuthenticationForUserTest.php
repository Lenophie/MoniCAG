<?php

namespace Tests\Feature;

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
        $this->actingAs($user);
    }
    
    /**
     * Tests basic user prevented from posting a new borrowing.
     *
     * @return void
     */
    public function testNoNewBorrowingRequestAllowedForUser()
    {
        $response = $this->json('POST', '/new-borrowing', []);
        $response->assertStatus(403);
    }

    /**
     * Tests basic user prevented from returning a borrowing.
     *
     * @return void
     */
    public function testNoReturnBorrowingRequestAllowedForUser()
    {
        $response = $this->json('POST', '/end-borrowing/returned', []);
        $response->assertStatus(403);
    }

    /**
     * Tests basic user prevented from declaring a borrowing as lost.
     *
     * @return void
     */
    public function testNoLostBorrowingRequestAllowedForUser()
    {
        $response = $this->json('POST', '/end-borrowing/lost', []);
        $response->assertStatus(403);
    }

    /**
     * Tests basic user prevented from adding a new inventory item.
     *
     * @return void
     */
    public function testNoAddInventoryItemRequestAllowedForUser()
    {
        $response = $this->json('POST', '/edit-inventory', []);
        $response->assertStatus(403);
    }

    /**
     * Tests basic user prevented from deleting an inventory item.
     *
     * @return void
     */
    public function testNoDeleteInventoryItemRequestAllowedForUser()
    {
        $response = $this->json('DELETE', '/edit-inventory', []);
        $response->assertStatus(403);
    }

    /**
     * Tests basic user prevented from patching an inventory item.
     *
     * @return void
     */
    public function testNoPatchInventoryItemRequestAllowedForUser()
    {
        $response = $this->json('PATCH', '/edit-inventory', []);
        $response->assertStatus(403);
    }

    /**
     * Tests basic user prevented from patching a user.
     *
     * @return void
     */
    public function testNoPatchUserRequestAllowedForUser()
    {
        $response = $this->json('PATCH', '/edit-users', []);
        $response->assertStatus(403);
    }

    /**
     * Tests basic user prevented from deleting a user.
     *
     * @return void
     */
    public function testNoDeleteUserRequestAllowedForUser()
    {
        $response = $this->json('DELETE', '/edit-users', []);
        $response->assertStatus(403);
    }
}

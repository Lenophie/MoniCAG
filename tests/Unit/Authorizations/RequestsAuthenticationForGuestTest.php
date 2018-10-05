<?php

namespace Tests\Feature;

use Tests\TestCase;

class RequestsAuthenticationForGuestTest extends TestCase
{
    /**
     * Tests guest prevented from posting a new borrowing.
     *
     * @return void
     */
    public function testNoNewBorrowingRequestAllowedForGuest()
    {
        $response = $this->json('POST', '/new-borrowing', []);
        $response->assertStatus(401);
    }

    /**
     * Tests guest prevented from returning a borrowing.
     *
     * @return void
     */
    public function testNoReturnBorrowingRequestAllowedForGuest()
    {
        $response = $this->json('PATCH', '/end-borrowing/returned', []);
        $response->assertStatus(401);
    }

    /**
     * Tests guest prevented from declaring a borrowing as lost.
     *
     * @return void
     */
    public function testNoLostBorrowingRequestAllowedForGuest()
    {
        $response = $this->json('PATCH', '/end-borrowing/lost', []);
        $response->assertStatus(401);
    }

    /**
     * Tests guest prevented from adding a new inventory item.
     *
     * @return void
     */
    public function testNoAddInventoryItemRequestAllowedForGuest()
    {
        $response = $this->json('POST', '/edit-inventory', []);
        $response->assertStatus(401);
    }

    /**
     * Tests guest prevented from deleting an inventory item.
     *
     * @return void
     */
    public function testNoDeleteInventoryItemRequestAllowedForGuest()
    {
        $response = $this->json('DELETE', '/edit-inventory', []);
        $response->assertStatus(401);
    }

    /**
     * Tests guest prevented from patching an inventory item.
     *
     * @return void
     */
    public function testNoPatchInventoryItemRequestAllowedForGuest()
    {
        $response = $this->json('PATCH', '/edit-inventory', []);
        $response->assertStatus(401);
    }

    /**
     * Tests guest prevented from patching a user.
     *
     * @return void
     */
    public function testNoPatchUserRequestAllowedForGuest()
    {
        $response = $this->json('PATCH', '/edit-users', []);
        $response->assertStatus(401);
    }

    /**
     * Tests guest prevented from deleting a user.
     *
     * @return void
     */
    public function testNoDeleteUserRequestAllowedForGuest()
    {
        $response = $this->json('DELETE', '/edit-users', []);
        $response->assertStatus(401);
    }
}

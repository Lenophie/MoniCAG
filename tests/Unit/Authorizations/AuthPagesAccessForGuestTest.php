<?php

use Tests\TestCase;

class AuthPagesAccessForGuestTest extends TestCase
{
    /**
     * Tests login page access for guests.
     *
     * @return void
     */
    public function testLoginPageAccessForGuest()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    /**
     * Tests register page access for guests.
     *
     * @return void
     */
    public function testRegisterPageAccessForGuest()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    /**
     * Tests password reset page access for guests.
     *
     * @return void
     */
    public function testPasswordResetPageAccessForGuest()
    {
        $response = $this->get('/password/reset');
        $response->assertStatus(200);
    }

    /**
     * Tests password change page access for guests.
     *
     * @return void
     */
    public function testPasswordChangePageAccessForGuest()
    {
        $response = $this->get('/password/change');
        $response->assertStatus(302);
    }
    /**
     * Tests email change page access for guests.
     *
     * @return void
     */
    public function testEmailChangePageAccessForGuest()
    {
        $response = $this->get('/email/change');
        $response->assertStatus(302);
    }


    /**
     * Tests account page access for guests.
     *
     * @return void
     */
    public function testAccountPageAccessForGuest()
    {
        $response = $this->get('/account');
        $response->assertStatus(302);
    }
}

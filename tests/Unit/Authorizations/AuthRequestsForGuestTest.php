<?php

use Tests\TestCase;

class AuthRequestsForGuestTest extends TestCase
{
    /**
     * Tests guest allowed to register.
     *
     * @return void
     */
    public function testRegistrationAllowedForGuest()
    {
        $response = $this->json('POST', '/register', []);
        $response->assertStatus(422);
    }

    /**
     * Tests guest allowed to login.
     *
     * @return void
     */
    public function testLoginAllowedForGuest()
    {
        $response = $this->json('POST', '/login', []);
        $response->assertStatus(422);
    }

    /**
     * Tests guest allowed to reset password.
     *
     * @return void
     */
    public function testPasswordResetAllowedForGuest()
    {
        $response = $this->json('POST', '/password/reset', []);
        $response->assertStatus(422);
    }

    /**
     * Tests guest prevented from using the account deletion route.
     *
     * @return void
     */
    public function testNoAccountDeletionForGuest()
    {
        $response = $this->json('DELETE', '/account', []);
        $response->assertStatus(401);
    }

    /**
     * Tests guest prevented from using the password change route.
     *
     * @return void
     */
    public function testNoPasswordChangeForGuest()
    {
        $response = $this->json('POST', '/password/change', []);
        $response->assertStatus(401);
    }

    /**
     * Tests guest prevented from using the email change route.
     *
     * @return void
     */
    public function testNoEmailChangeForGuest()
    {
        $response = $this->json('POST', '/email/change', []);
        $response->assertStatus(401);
    }
}

<?php

use Illuminate\Http\Response;
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
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Tests guest allowed to login.
     *
     * @return void
     */
    public function testLoginAllowedForGuest()
    {
        $response = $this->json('POST', '/login', []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Tests guest allowed to reset password.
     *
     * @return void
     */
    public function testPasswordResetAllowedForGuest()
    {
        $response = $this->json('POST', '/password/reset', []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Tests guest prevented from using the password change route.
     *
     * @return void
     */
    public function testNoPasswordChangeForGuest()
    {
        $response = $this->json('POST', '/password/change', []);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Tests guest prevented from using the email change route.
     *
     * @return void
     */
    public function testNoEmailChangeForGuest()
    {
        $response = $this->json('POST', '/email/change', []);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}

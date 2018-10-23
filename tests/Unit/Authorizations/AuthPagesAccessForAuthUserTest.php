<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AuthPagesAccessForAuthUserTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp()
    {
        Parent::setUp();
        $user = factory(User::class)->create();
        $this->actingAs($user);
    }

    /**
     * Tests login page access for authenticated users.
     *
     * @return void
     */
    public function testLoginPageAccessForAuthUsers()
    {
        $response = $this->get('/login');
        $response->assertStatus(302);
    }

    /**
     * Tests register page access for authenticated users.
     *
     * @return void
     */
    public function testRegisterPageAccessForAuthUsers()
    {
        $response = $this->get('/register');
        $response->assertStatus(302);
    }

    /**
     * Tests password reset page access for authenticated users.
     *
     * @return void
     */
    public function testPasswordResetPageAccessForAuthUsers()
    {
        $response = $this->get('/password/reset');
        $response->assertStatus(302);
    }

    /**
     * Tests password change page access for authenticated users.
     *
     * @return void
     */
    public function testPasswordChangePageAccessForAuthUsers()
    {
        $response = $this->get('/password/change');
        $response->assertStatus(200);
    }
    /**
     * Tests email change page access for authenticated users.
     *
     * @return void
     */
    public function testEmailChangePageAccessForAuthUsers()
    {
        $response = $this->get('/email/change');
        $response->assertStatus(200);
    }

    /**
     * Tests account page access for authenticated users.
     *
     * @return void
     */
    public function testAccountPageAccessForAuthUsers()
    {
        $response = $this->get('/account');
        $response->assertStatus(200);
    }
}

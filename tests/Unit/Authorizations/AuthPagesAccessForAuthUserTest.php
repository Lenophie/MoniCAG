<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class AuthPagesAccessForAuthUserTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
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
        $response->assertStatus(Response::HTTP_FOUND);
    }

    /**
     * Tests register page access for authenticated users.
     *
     * @return void
     */
    public function testRegisterPageAccessForAuthUsers()
    {
        $response = $this->get('/register');
        $response->assertStatus(Response::HTTP_FOUND);
    }

    /**
     * Tests password reset page access for authenticated users.
     *
     * @return void
     */
    public function testPasswordResetPageAccessForAuthUsers()
    {
        $response = $this->get('/password/reset');
        $response->assertStatus(Response::HTTP_FOUND);
    }

    /**
     * Tests password change page access for authenticated users.
     *
     * @return void
     */
    public function testPasswordChangePageAccessForAuthUsers()
    {
        $response = $this->get('/password/change');
        $response->assertStatus(Response::HTTP_OK);
    }
    /**
     * Tests email change page access for authenticated users.
     *
     * @return void
     */
    public function testEmailChangePageAccessForAuthUsers()
    {
        $response = $this->get('/email/change');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Tests account page access for authenticated users.
     *
     * @return void
     */
    public function testAccountPageAccessForAuthUsers()
    {
        $response = $this->get(route('account'));
        $response->assertStatus(Response::HTTP_OK);
    }
}

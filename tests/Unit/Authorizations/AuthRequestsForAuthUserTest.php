<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class AuthRequestsForAuthUserTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        Parent::setUp();
        $user = factory(User::class)->create();
        $this->actingAs($user);
    }

    /**
     * Tests no login for authenticated user.
     *
     * @return void
     */
    public function testNoRegistrationForAuthUsers()
    {
        $response = $this->json('POST', '/register', []);
        $response->assertStatus(Response::HTTP_FOUND);
    }

    /**
     * Tests no login for authenticated user.
     *
     * @return void
     */
    public function testNoLoginForAuthUsers()
    {
        $response = $this->json('POST', '/login', []);
        $response->assertStatus(Response::HTTP_FOUND);
    }

    /**
     * Tests no password reset for authenticated user.
     *
     * @return void
     */
    public function testNoPasswordResetAllowedForAuthUsers()
    {
        $response = $this->json('POST', '/password/reset', []);
        $response->assertStatus(Response::HTTP_FOUND);
    }

    /**
     * Tests authenticated user allowed to delete its account.
     *
     * @return void
     */
    public function testAccountDeletionAllowedForAuthUsers()
    {
        $response = $this->json('DELETE', route('account'), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Tests authenticated user allowed to change its password.
     *
     * @return void
     */
    public function testPasswordChangeAllowedForAuthUsers()
    {
        $response = $this->json('POST', '/password/change', []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Tests authenticated user allowed to change its email address.
     *
     * @return void
     */
    public function testEmailChangeAllowedForAuthUsers()
    {
        $response = $this->json('POST', '/email/change', []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}

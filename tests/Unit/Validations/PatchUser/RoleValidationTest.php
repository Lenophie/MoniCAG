<?php

use App\User;
use App\UserRole;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RoleValidationTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp()
    {
        Parent::setUp();
        $admin = factory(User::class)->state('admin')->create();
        $this->actingAs($admin, 'api');
    }

    /**
     * Tests role requirement.
     *
     * @return void
     */
    public function testRoleRequirement()
    {
        $user = factory(User::class)->create();
        $response = $this->json('PATCH', '/api/users/' . $user->id . '/role', []);
        $response->assertJsonValidationErrors('role');
    }

    /**
     * Tests role not an integer rejection.
     *
     * @return void
     */
    public function testRoleNotAnIntegerRejection()
    {
        $user = factory(User::class)->create();
        $response = $this->json('PATCH', '/api/users/' . $user->id . '/role', [
            'role' => 'I am a string'
        ]);
        $response->assertJsonValidationErrors('role');
        $response = $this->json('PATCH', '/api/users/' . $user->id . '/role', [
            'role' => null
        ]);
        $response->assertJsonValidationErrors('role');
        $response = $this->json('PATCH', '/api/users/' . $user->id . '/role', [
            'role' => [0]
        ]);
        $response->assertJsonValidationErrors('role');
    }

    /**
     * Tests correct role validation.
     *
     * @return void
     */
    public function testCorrectRoleValidation()
    {
        $user = factory(User::class)->create();
        $response = $this->json('PATCH', '/api/users/' . $user->id . '/role', [
            'role' => UserRole::NONE
        ]);
        $response->assertJsonMissingValidationErrors('role');
        $response = $this->json('PATCH', '/api/users/' . $user->id . '/role', [
            'role' => UserRole::LENDER
        ]);
        $response->assertJsonMissingValidationErrors('role');
        $response = $this->json('PATCH', '/api/users/' . $user->id . '/role', [
            'role' => UserRole::ADMINISTRATOR
        ]);
        $response->assertJsonMissingValidationErrors('role');
    }

    /**
     * Tests incorrect role rejection.
     *
     * @return void
     */
    public function testIncorrectRoleRejection()
    {
        $user = factory(User::class)->create();
        $response = $this->json('PATCH', '/api/users/' . $user->id . '/role', [
            'role' => 250
        ]);
        $response->assertJsonValidationErrors('role');
    }
}

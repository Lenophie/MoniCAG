<?php

namespace Tests\Feature;

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
        $this->actingAs($admin);
    }

    /**
     * Tests role requirement.
     *
     * @return void
     */
    public function testRoleRequirement()
    {
        $response = $this->json('PATCH', '/edit-users', []);
        $response->assertJsonValidationErrors('role');
    }

    /**
     * Tests role not an integer rejection.
     *
     * @return void
     */
    public function testRoleNotAnIntegerRejection()
    {
        $response = $this->json('PATCH', '/edit-users', [
            'role' => 'I am a string'
        ]);
        $response->assertJsonValidationErrors('role');
        $response = $this->json('PATCH', '/edit-users', [
            'role' => null
        ]);
        $response->assertJsonValidationErrors('role');
        $response = $this->json('PATCH', '/edit-users', [
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
        $response = $this->json('PATCH', '/edit-users', [
            'role' => UserRole::NONE
        ]);
        $response->assertJsonMissingValidationErrors('role');
        $response = $this->json('PATCH', '/edit-users', [
            'role' => UserRole::LENDER
        ]);
        $response->assertJsonMissingValidationErrors('role');
        $response = $this->json('PATCH', '/edit-users', [
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
        $response = $this->json('PATCH', '/edit-users', [
            'role' => 250
        ]);
        $response->assertJsonValidationErrors('role');
    }
}

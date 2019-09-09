<?php

use App\User;
use App\UserRole;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleValidationTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    private $admin;

    protected function setUp(): void
    {
        Parent::setUp();
        $this->admin = factory(User::class)->state('admin')->create();
        $this->actingAs($this->admin, 'api');
    }

    /**
     * Tests role requirement.
     *
     * @return void
     */
    public function testRoleRequirement()
    {
        $user = factory(User::class)->create();
        $response = $this->json('PATCH', route('users.changeRole', $user->id), []);
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
        $response = $this->json('PATCH', route('users.changeRole', $user->id), [
            'role' => 'I am a string'
        ]);
        $response->assertJsonValidationErrors('role');

        $response = $this->json('PATCH', route('users.changeRole', $user->id), [
            'role' => null
        ]);
        $response->assertJsonValidationErrors('role');

        $response = $this->json('PATCH', route('users.changeRole', $user->id), [
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
        $response = $this->json('PATCH', route('users.changeRole', $user->id), [
            'role' => UserRole::NONE
        ]);
        $response->assertJsonMissingValidationErrors('role');

        $response = $this->json('PATCH', route('users.changeRole', $user->id), [
            'role' => UserRole::LENDER
        ]);
        $response->assertJsonMissingValidationErrors('role');

        $response = $this->json('PATCH', route('users.changeRole', $user->id), [
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
        $nonExistentRoleId = UserRole::all()->max('id') + 1;
        $response = $this->json('PATCH', route('users.changeRole', $user->id), [
            'role' => $nonExistentRoleId
        ]);
        $response->assertJsonValidationErrors('role');
    }
}

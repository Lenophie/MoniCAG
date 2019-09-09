<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PasswordValidationForPatchingTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    private $adminPassword;
    private $user;

    protected function setUp(): void
    {
        Parent::setUp();
        $this->faker->seed(0);

        // Setup admin
        $this->adminPassword = $this->faker()->unique()->password;
        $admin = factory(User::class)->state('admin')->create([
            'password' => bcrypt($this->adminPassword)
        ]);
        $this->actingAs($admin, 'api');

        $this->user = factory(User::class)->create();
    }

    /**
     * Tests password requirement.
     *
     * @return void
     */
    public function testPasswordRequirement()
    {
        $response = $this->json('PATCH', route('users.changeRole', $this->user->id), []);
        $response->assertJsonValidationErrors('password');
    }

    /**
     * Tests current user correct password validation.
     *
     * @return void
     */
    public function testCorrectPasswordValidation()
    {
        $response = $this->json('PATCH', route('users.changeRole', $this->user->id), [
            'password' => $this->adminPassword
        ]);
        $response->assertJsonMissingValidationErrors('password');
    }

    /**
     * Tests current user incorrect password rejection.
     *
     * @return void
     */
    public function testIncorrectPasswordRejection()
    {
        $response = $this->json('PATCH', route('users.changeRole', $this->user->id), [
            'password' => $this->faker->unique()->password
        ]);
        $response->assertJsonValidationErrors('password');
    }

    /**
     * Tests the rejection of a user using the password of another user.
     *
     * @return void
     */
    public function testUsingOtherUserPasswordRejection() {
        $otherUserPassword = $this->faker->unique()->password;
        factory(User::class)->create(['password' => bcrypt($otherUserPassword)]);
        $response = $this->json('PATCH', route('users.changeRole', $this->user->id), [
            'password' => $otherUserPassword
        ]);
        $response->assertJsonValidationErrors('password');
    }
}

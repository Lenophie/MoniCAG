<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PasswordValidationForChangingEmailTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    protected function setUp(): void
    {
        Parent::setUp();
        $this->faker->seed(0);
    }

    /**
     * Tests password requirement.
     *
     * @return void
     */
    public function testPasswordRequirement()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $response = $this->json('POST', '/email/change', []);
        $response->assertJsonValidationErrors('password');
    }

    /**
     * Tests current user correct password validation.
     *
     * @return void
     */
    public function testCorrectPasswordValidation()
    {
        $userPassword = $this->faker->unique()->password;
        $user = factory(User::class)->create(['password' => bcrypt($userPassword)]);
        $this->actingAs($user);
        $response = $this->json('POST', '/email/change', [
            'password' => $userPassword
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
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $response = $this->json('POST', '/email/change', [
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
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $otherUserPassword = $this->faker->unique()->password;
        factory(User::class)->create(['password' => bcrypt($otherUserPassword)]);
        $response = $this->json('POST', '/email/change', [
            'password' => $otherUserPassword
        ]);
        $response->assertJsonValidationErrors('password');
    }
}

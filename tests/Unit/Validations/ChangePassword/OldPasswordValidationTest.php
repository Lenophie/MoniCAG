<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OldPasswordValidationTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    protected function setUp(): void
    {
        Parent::setUp();
        $this->faker->seed(0);
    }

    /**
     * Tests old password requirement.
     *
     * @return void
     */
    public function testOldPasswordRequirement()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $response = $this->json('POST', '/password/change', []);
        $response->assertJsonValidationErrors('oldPassword');
    }

    /**
     * Tests current user correct old password validation.
     *
     * @return void
     */
    public function testCorrectOldPasswordValidation()
    {
        $userOldPassword = $this->faker->unique()->password;
        $user = factory(User::class)->create(['password' => bcrypt($userOldPassword)]);
        $this->actingAs($user);
        $response = $this->json('POST', '/password/change', [
            'oldPassword' => $userOldPassword
        ]);
        $response->assertJsonMissingValidationErrors('oldPassword');
    }

    /**
     * Tests current user incorrect old password rejection.
     *
     * @return void
     */
    public function testIncorrectOldPasswordRejection()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $response = $this->json('POST', '/password/change', [
            'oldPassword' => $this->faker->unique()->password
        ]);
        $response->assertJsonValidationErrors('oldPassword');
    }

    /**
     * Tests the rejection of a user using the password of another user.
     *
     * @return void
     */
    public function testUsingOtherUserOldPasswordRejection() {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $otherUserOldPassword = $this->faker->unique()->password;
        factory(User::class)->create(['password' => bcrypt($otherUserOldPassword)]);
        $response = $this->json('POST', '/password/change', [
            'oldPassword' => $otherUserOldPassword
        ]);
        $response->assertJsonValidationErrors('oldPassword');
    }
}

<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewPasswordValidationTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    protected function setUp(): void
    {
        Parent::setUp();
        $this->faker->seed(0);
    }

    /**
     * Tests new password requirement.
     *
     * @return void
     */
    public function testNewPasswordRequirement()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $response = $this->json('POST', '/password/change', []);
        $response->assertJsonValidationErrors('newPassword');
    }

    /**
     * Tests unconfirmed new password rejection.
     *
     * @return void
     */
    public function testUnconfirmedNewPasswordRejection()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $newPassword = $this->faker->unique()->password;
        $response = $this->json('POST', '/password/change', [
            'newPassword' => $newPassword
        ]);
        $response->assertJsonValidationErrors('newPassword');
    }


    /**
     * Tests confirmed new password validation.
     *
     * @return void
     */
    public function testConfirmedNewPasswordValidation()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $newPassword = $this->faker->unique()->password;
        $response = $this->json('POST', '/password/change', [
            'newPassword' => $newPassword,
            'newPassword_confirmation' => $newPassword
        ]);
        $response->assertJsonMissingValidationErrors('newPassword');
    }
}

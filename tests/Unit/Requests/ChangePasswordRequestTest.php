<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ChangePasswordRequestTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    protected function setUp()
    {
        Parent::setUp();
        $this->faker->seed(0);
    }

    /**
     * Tests change user password request.
     *
     * @return void
     */
    public function testChangePasswordRequest()
    {
        $userPassword = $this->faker()->unique()->password;
        $user = factory(User::class)->create([
            'password' => bcrypt($userPassword)
        ]);
        $this->actingAs($user);
        $newPassword = $this->faker()->unique()->password;

        // Change email
        $response = $this->json('POST', '/password/change', [
            'oldPassword' => $userPassword,
            'newPassword' => $newPassword,
            'newPassword_confirmation' => $newPassword
        ]);

        // Check response
        $response->assertStatus(302);

        // Check new password set in database
        $newPasswordEntry = User::find($user->id)->select('password')->first()->password;
        $this->assertTrue(Hash::check($newPassword, $newPasswordEntry));
        $this->assertFalse(Hash::check($userPassword, $newPasswordEntry));
    }
}

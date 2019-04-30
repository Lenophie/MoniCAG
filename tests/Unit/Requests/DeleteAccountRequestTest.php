<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteAccountRequestTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    protected function setUp(): void
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

        // Change email
        $response = $this->json('DELETE', '/account', [
            'password' => $userPassword
        ]);

        // Check response
        $response->assertStatus(200);

        // Check user deleted from database
        $this->assertDatabaseMissing('users', [
            'id' => $user->id
        ]);
    }
}

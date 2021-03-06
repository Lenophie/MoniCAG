<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ChangeEmailRequestTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    protected function setUp(): void
    {
        Parent::setUp();
        $this->faker->seed(0);
    }

    /**
     * Tests change user email request.
     *
     * @return void
     */
    public function testChangeEmailRequest()
    {
        $userPassword = $this->faker()->unique()->password;
        $user = factory(User::class)->create([
            'password' => bcrypt($userPassword)
        ]);
        $this->actingAs($user);
        $newEmail = $this->faker()->unique()->email;

        // Change email
        $response = $this->json('POST', '/email/change', [
            'password' => $userPassword,
            'email' => $newEmail
        ]);

        // Check response
        $response->assertStatus(Response::HTTP_FOUND);

        // Check email modification in database
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $newEmail
        ]);
    }
}

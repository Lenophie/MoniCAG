<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmailValidationTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    protected function setUp(): void
    {
        Parent::setUp();
        $this->faker->seed(0);
    }

    /**
     * Tests email requirement.
     *
     * @return void
     */
    public function testEmailRequirement()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $response = $this->json('POST', '/email/change', []);
        $response->assertJsonValidationErrors('email');
    }

    /**
     * Tests correct email validation.
     *
     * @return void
     */
    public function testCorrectEmailValidation()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $response = $this->json('POST', '/email/change', [
            'email' => $this->faker()->unique()->email
        ]);
        $response->assertJsonMissingValidationErrors('email');
    }

    /**
     * Tests existent email rejection.
     *
     * @return void
     */
    public function testExistentEmailRejection()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $otherUser = factory(User::class)->create();
        $response = $this->json('POST', '/email/change', [
            'password' => $otherUser->email
        ]);
        $response->assertJsonValidationErrors('email');
    }
}

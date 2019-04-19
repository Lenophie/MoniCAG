<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BorrowerPasswordValidationTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    protected function setUp()
    {
        Parent::setUp();
        $this->faker->seed(0);
        $lender = factory(User::class)->state('lender')->create();
        $this->actingAs($lender);
    }

    /**
     * Tests borrower password requirement.
     *
     * @return void
     */
    public function testBorrowerPasswordRequirement()
    {
        $user = factory(User::class)->create();
        $response = $this->json('POST', '/new-borrowing', [
            'borrowerEmail' => $user->email
        ]);
        $response->assertJsonValidationErrors('borrowerPassword');
    }

    /**
     * Tests registered borrower correct password validation.
     *
     * @return void
     */
    public function testCorrectBorrowerPasswordValidation()
    {
        $borrowerPassword = $this->faker->unique()->password;
        $user = factory(User::class)->create(['password' => bcrypt($borrowerPassword)]);
        $response = $this->json('POST', '/new-borrowing', [
            'borrowerEmail' => $user->email,
            'borrowerPassword' => $borrowerPassword
        ]);
        $response->assertJsonMissingValidationErrors('borrowerPassword');
    }

    /**
     * Tests registered borrower incorrect password rejection.
     *
     * @return void
     */
    public function testIncorrectBorrowerPasswordRejection()
    {
        $user = factory(User::class)->create();
        $response = $this->json('POST', '/new-borrowing', [
            'borrowerEmail' => $user->email,
            'borrowerPassword' => $this->faker->unique()->password
        ]);
        $response->assertJsonValidationErrors('borrowerPassword');
    }

    /**
     * Tests the rejection of a borrower using the password of another user.
     *
     * @return void
     */
    public function testBorrowerUsingOtherUserPasswordRejection() {
        $borrower = factory(User::class)->create();
        $otherUserPassword = $this->faker->unique()->password;
        factory(User::class)->create(['password' => bcrypt($otherUserPassword)]);
        $response = $this->json('POST', '/new-borrowing', [
            'borrowerEmail' => $borrower->email,
            'borrowerPassword' => $otherUserPassword
        ]);
        $response->assertJsonValidationErrors('borrowerPassword');
    }
}

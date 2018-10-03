<?php

namespace Tests\Feature;

use App\User;
use Carbon\Carbon;
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
        $lender = factory(User::class)->state('lender')->create();
        $this->actingAs($lender);
        $this->faker->seed(0);
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

    /**
     * Tests borrower password requirement validation.
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
     * Tests expected return date requirement validation.
     *
     * @return void
     */
    public function testExpectedReturnDateRequirement()
    {
        $response = $this->json('POST', '/new-borrowing', []);
        $response->assertJsonValidationErrors('expectedReturnDate');
    }

    /**
     * Tests expected return date incorrect format rejection.
     *
     * @return void
     */
    public function testExpectedReturnDateFormatRejection()
    {
        $response = $this->json('POST', '/new-borrowing', [
            'expectedReturnDate' => Carbon::now()->format('Y-m-d')
        ]);
        $response->assertJsonValidationErrors('expectedReturnDate');
    }

    /**
     * Tests expected return date can be current date validation.
     *
     * @return void
     */
    public function testExpectedReturnDateCanBeTodayValidation()
    {
        $response = $this->json('POST', '/new-borrowing', [
            'expectedReturnDate' => Carbon::now()->format('d/m/Y')
        ]);
        $response->assertJsonMissingValidationErrors('expectedReturnDate');
    }

    /**
     * Tests expected return date can be later date validation.
     *
     * @return void
     */
    public function testExpectedReturnDateCanBeLaterValidation()
    {
        $laterDate = Carbon::now()->addDay();
        $response = $this->json('POST', '/new-borrowing', [
            'expectedReturnDate' => $laterDate->format('d/m/Y')
        ]);
        $response->assertJsonMissingValidationErrors('expectedReturnDate');
    }

    /**
     * Tests expected return date can't be earlier date validation.
     *
     * @return void
     */
    public function testExpectedReturnDateCantBeEarlierValidation()
    {
        $earlierDate = Carbon::now()->subDay();
        $response = $this->json('POST', '/new-borrowing', [
            'expectedReturnDate' => $earlierDate->format('d/m/Y')
        ]);
        $response->assertJsonValidationErrors('expectedReturnDate');
    }
}

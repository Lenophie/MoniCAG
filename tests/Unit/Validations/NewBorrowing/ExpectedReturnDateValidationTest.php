<?php

namespace Tests\Feature;

use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ExpectedReturnDateValidationTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp()
    {
        Parent::setUp();
        $lender = factory(User::class)->state('lender')->create();
        $this->actingAs($lender);
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
    public function testExpectedReturnDateIncorrectFormatRejection()
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

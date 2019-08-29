<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ExpectedReturnDateValidationTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        Parent::setUp();
        $lender = factory(User::class)->state('lender')->create();
        $this->actingAs($lender, 'api');
    }

    /**
     * Tests expected return date requirement.
     *
     * @return void
     */
    public function testExpectedReturnDateRequirement()
    {
        $response = $this->json('POST', '/api/borrowings', []);
        $response->assertJsonValidationErrors('expectedReturnDate');
    }

    /**
     * Tests expected return date incorrect format rejection.
     *
     * @return void
     */
    public function testExpectedReturnDateIncorrectFormatRejection()
    {
        $response = $this->json('POST', '/api/borrowings', [
            'expectedReturnDate' => Carbon::now()->format('d/m/Y')
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
        $response = $this->json('POST', '/api/borrowings', [
            'expectedReturnDate' => Carbon::now()->format('Y-m-d')
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
        $response = $this->json('POST', '/api/borrowings', [
            'expectedReturnDate' => $laterDate->format('Y-m-d')
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
        $response = $this->json('POST', '/api/borrowings', [
            'expectedReturnDate' => $earlierDate->format('Y-m-d')
        ]);
        $response->assertJsonValidationErrors('expectedReturnDate');
    }
}

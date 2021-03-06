<?php

use App\Borrowing;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BorrowingsValidationTest extends TestCase
{
    use DatabaseTransactions;

    private $returnLender;

    protected function setUp(): void
    {
        Parent::setUp();
        $lender = factory(User::class)->state('lender')->create();
        $this->actingAs($lender, 'api');
        $this->returnLender = $lender;
    }

    /**
     * Tests selected borrowings requirement.
     *
     * @return void
     */
    public function testSelectedBorrowingsRequirement()
    {
        $response = $this->json('PATCH', route('borrowings.return'), []);
        $response->assertJsonValidationErrors('selectedBorrowings');

        $response = $this->json('PATCH', route('borrowings.return'), [
            'selectedBorrowings' => []
        ]);
        $response->assertJsonValidationErrors('selectedBorrowings');
    }

    /**
     * Tests selected borrowings not an array rejection.
     *
     * @return void
     */
    public function testSelectedBorrowingsNotAnArrayRejection()
    {
        $response = $this->json('PATCH', route('borrowings.return'), [
            'selectedBorrowings' => 0
        ]);
        $response->assertJsonValidationErrors('selectedBorrowings');

        $response = $this->json('PATCH', route('borrowings.return'), [
            'selectedBorrowings' => 'I am a string'
        ]);
        $response->assertJsonValidationErrors('selectedBorrowings');

        $response = $this->json('PATCH', route('borrowings.return'), [
            'selectedBorrowings' => null
        ]);
        $response->assertJsonValidationErrors('selectedBorrowings');
    }

    /**
     * Tests selected borrowing value not an integer rejection.
     *
     * @return void
     */
    public function testSelectedBorrowingValueNotAnIntegerRejection()
    {
        $response = $this->json('PATCH', route('borrowings.return'), [
            'selectedBorrowings' => ['I am a string']
        ]);
        $response->assertJsonValidationErrors('selectedBorrowings.0');

        $response = $this->json('PATCH', route('borrowings.return'), [
            'selectedBorrowings' => [[0]]
        ]);
        $response->assertJsonValidationErrors('selectedBorrowings.0');

        $response = $this->json('PATCH', route('borrowings.return'), [
            'selectedBorrowings' => [null]
        ]);
        $response->assertJsonValidationErrors('selectedBorrowings.0');
    }

    /**
     * Tests ending of a single borrowing validation.
     *
     * @return void
     */
    public function testEndingOfSingleBorrowingValidation() {
        $borrowing = factory(Borrowing::class)->create();

        $response = $this->json('PATCH', route('borrowings.return'), [
            'selectedBorrowings' => [$borrowing->id]
        ]);
        $response->assertJsonMissingValidationErrors('selectedBorrowings.0');
    }

    /**
     * Tests ending of multiple borrowings validation.
     *
     * @return void
     */
    public function testEndingOfMultipleBorrowingsValidation() {
        $borrowingsIDs = factory(Borrowing::class, 5)->create()->pluck('id');

        $response = $this->json('PATCH', route('borrowings.return'), [
            'selectedBorrowings' => $borrowingsIDs
        ]);
        for ($i = 0; $i < 5; $i++) $response->assertJsonMissingValidationErrors("selectedBorrowings.{$i}");
    }

    /**
     * Tests ending of an already finished borrowing rejection.
     *
     * @return void
     */
    public function testEndingOfAlreadyFinishedBorrowingRejection() {
        $borrowing = factory(Borrowing::class)->state('finished')->create();

        $response = $this->json('PATCH', route('borrowings.return'), [
            'selectedBorrowings' => [$borrowing->id]
        ]);
        $response->assertJsonValidationErrors('selectedBorrowings.0');
    }

    /**
     * Tests ending of a duplicate borrowing rejection.
     *
     * @return void
     */
    public function testEndingOfDuplicateBorrowingsRejection() {
        $borrowing = factory(Borrowing::class)->create();

        $response = $this->json('PATCH', route('borrowings.return'), [
            'selectedBorrowings' => [$borrowing->id, $borrowing->id]
        ]);
        $response->assertJsonValidationErrors('selectedBorrowings.0');
    }

    /**
     * Tests ending of an non-existent borrowing rejection.
     *
     * @return void
     */
    public function testEndingOfNonExistentBorrowingRejection() {
        $nonExistentBorrowingID = factory(Borrowing::class, 5)->create()->max('id') + 1;

        $response = $this->json('PATCH', route('borrowings.return'), [
            'selectedBorrowings' => [$nonExistentBorrowingID]
        ]);
        $response->assertJsonValidationErrors('selectedBorrowings.0');
    }

    /**
     * Tests self return of borrowing rejection.
     *
     * @return void
     */
    public function testSelfReturnRejection() {
        $borrowing = factory(Borrowing::class)->create([
            'borrower_id' => $this->returnLender->id
        ]);

        $response = $this->json('PATCH', route('borrowings.return'), [
            'selectedBorrowings' => [$borrowing->id]
        ]);
        $response->assertJsonValidationErrors('selectedBorrowings.0');
    }
}

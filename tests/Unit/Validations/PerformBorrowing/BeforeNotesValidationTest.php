<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BeforeNotesValidationTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        Parent::setUp();
        $lender = factory(User::class)->state('lender')->create();
        $this->actingAs($lender, 'api');
    }

    /**
     * Tests before notes nullability.
     *
     * @return void
     */
    public function testBeforeNotesNullability()
    {
        $response = $this->json('POST', '/api/borrowings', [
            'notes' => null
        ]);
        $response->assertJsonMissingValidationErrors('notes');
    }

    /**
     * Tests before notes not a string rejection.
     *
     * @return void
     */
    public function testBeforeNotesNotAStringRejection()
    {
        $response = $this->json('POST', '/api/borrowings', [
            'notes' => ['I am a string']
        ]);
        $response->assertJsonValidationErrors('notes');
        $response = $this->json('POST', '/api/borrowings', [
            'notes' => 1
        ]);
        $response->assertJsonValidationErrors('notes');
    }

    /**
     * Tests correct before notes validation.
     *
     * @return void
     */
    public function testCorrectBeforeNotesValidation()
    {
        $response = $this->json('POST', '/api/borrowings', [
            'notes' => 'I am a string'
        ]);
        $response->assertJsonMissingValidationErrors('notes');
    }
}

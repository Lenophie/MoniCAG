<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DurationsValidationTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp()
    {
        Parent::setUp();
        $admin = factory(User::class)->state('admin')->create();
        $this->actingAs($admin);
    }

    /**
     * Tests durations nullability.
     *
     * @return void
     */
    public function testDurationsNullability()
    {
        $response = $this->json('POST', '/edit-inventory', [
            'durationMin' => null,
            'durationMax' => null
        ]);
        $response->assertJsonMissingValidationErrors('durationMin');
        $response->assertJsonMissingValidationErrors('durationMax');
    }

    /**
     * Tests durations not integers rejection.
     *
     * @return void
     */
    public function testDurationsNotIntegersRejection()
    {
        $response = $this->json('POST', '/edit-inventory', [
            'durationMin' => 'I am a string',
            'durationMax' => 'I am a string'
        ]);
        $response->assertJsonValidationErrors('durationMin');
        $response->assertJsonValidationErrors('durationMax');
        $response = $this->json('POST', '/edit-inventory', [
            'durationMin' => [],
            'durationMax' => []
        ]);
        $response->assertJsonValidationErrors('durationMin');
        $response->assertJsonValidationErrors('durationMax');
    }

    /**
     * Tests durations not integers rejection.
     *
     * @return void
     */
    public function testDurationsInferiorToZeroRejection()
    {
        $response = $this->json('POST', '/edit-inventory', [
            'durationMin' => -1,
            'durationMax' => -1
        ]);
        $response->assertJsonValidationErrors('durationMin');
        $response->assertJsonValidationErrors('durationMax');
    }

    /**
     * Tests max duration inferior to min duration rejection.
     *
     * @return void
     */
    public function testMaxDurationInferiorToMinDurationRejection()
    {
        $response = $this->json('POST', '/edit-inventory', [
            'durationMin' => 20,
            'durationMax' => 5
        ]);
        $response->assertJsonValidationErrors('durationMax');
    }

    /**
     * Tests single duration filling validation.
     *
     * @return void
     */
    public function testSingleDurationFillingValidation()
    {
        $response = $this->json('POST', '/edit-inventory', [
            'durationMin' => 5
        ]);
        $response->assertJsonMissingValidationErrors('durationMin');
        $response->assertJsonMissingValidationErrors('durationMax');
        $response = $this->json('POST', '/edit-inventory', [
            'durationMax' => 5
        ]);
        $response->assertJsonMissingValidationErrors('durationMin');
        $response->assertJsonMissingValidationErrors('durationMax');
    }

    /**
     * Tests correct durations validation.
     *
     * @return void
     */
    public function testCorrectDurationsValidation()
    {
        $response = $this->json('POST', '/edit-inventory', [
            'durationMin' => 5,
            'durationMax' => 20
        ]);
        $response->assertJsonMissingValidationErrors('durationMin');
        $response->assertJsonMissingValidationErrors('durationMax');
    }
}

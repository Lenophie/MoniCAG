<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class DurationsValidationForAddingTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        Parent::setUp();
        $admin = factory(User::class)->state('admin')->create();
        $this->actingAs($admin, 'api');
    }

    /**
     * Tests durations nullability.
     *
     * @return void
     */
    public function testDurationsNullability()
    {
        $response = $this->json('POST', '/api/inventoryItems', [
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
        $response = $this->json('POST', '/api/inventoryItems', [
            'durationMin' => 'I am a string',
            'durationMax' => 'I am a string'
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('durationMin');
        $response->assertJsonValidationErrors('durationMax');

        $response = $this->json('POST', '/api/inventoryItems', [
            'durationMin' => [],
            'durationMax' => []
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
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
        $response = $this->json('POST', '/api/inventoryItems', [
            'durationMin' => -1,
            'durationMax' => -1
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
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
        $response = $this->json('POST', '/api/inventoryItems', [
            'durationMin' => 20,
            'durationMax' => 5
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('durationMax');
    }

    /**
     * Tests single duration filling validation.
     *
     * @return void
     */
    public function testSingleDurationFillingValidation()
    {
        $response = $this->json('POST', '/api/inventoryItems', [
            'durationMin' => 5
        ]);
        $response->assertJsonMissingValidationErrors('durationMin');
        $response->assertJsonMissingValidationErrors('durationMax');

        $response = $this->json('POST', '/api/inventoryItems', [
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
        $response = $this->json('POST', '/api/inventoryItems', [
            'durationMin' => 5,
            'durationMax' => 20
        ]);
        $response->assertJsonMissingValidationErrors('durationMin');
        $response->assertJsonMissingValidationErrors('durationMax');
    }
}

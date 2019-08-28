<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class PlayersValidationForAddingTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        Parent::setUp();
        $admin = factory(User::class)->state('admin')->create();
        $this->actingAs($admin, 'api');
    }

    /**
     * Tests players counts nullability.
     *
     * @return void
     */
    public function testPlayersCountsNullability()
    {
        $response = $this->json('POST', '/api/inventoryItems', [
            'playersMin' => null,
            'playersMax' => null
        ]);
        $response->assertJsonMissingValidationErrors('playersMin');
        $response->assertJsonMissingValidationErrors('playersMax');
    }

    /**
     * Tests players counts not integers rejection.
     *
     * @return void
     */
    public function testPlayersCountsNotIntegersRejection()
    {
        $response = $this->json('POST', '/api/inventoryItems', [
            'playersMin' => 'I am a string',
            'playersMax' => 'I am a string'
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('playersMin');
        $response->assertJsonValidationErrors('playersMax');

        $response = $this->json('POST', '/api/inventoryItems', [
            'playersMin' => [],
            'playersMax' => []
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('playersMin');
        $response->assertJsonValidationErrors('playersMax');
    }

    /**
     * Tests players counts not integers rejection.
     *
     * @return void
     */
    public function testPlayersCountsInferiorToZeroRejection()
    {
        $response = $this->json('POST', '/api/inventoryItems', [
            'playersMin' => -1,
            'playersMax' => -1
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('playersMin');
        $response->assertJsonValidationErrors('playersMax');
    }

    /**
     * Tests max players count inferior to min players count rejection.
     *
     * @return void
     */
    public function testMaxPlayersCountInferiorToMinPlayersCountRejection()
    {
        $response = $this->json('POST', '/api/inventoryItems', [
            'playersMin' => 20,
            'playersMax' => 5
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('playersMax');
    }

    /**
     * Tests single players count filling validation.
     *
     * @return void
     */
    public function testSinglePlayersCountFillingValidation()
    {
        $response = $this->json('POST', '/api/inventoryItems', [
            'playersMin' => 5
        ]);
        $response->assertJsonMissingValidationErrors('playersMin');
        $response->assertJsonMissingValidationErrors('playersMax');

        $response = $this->json('POST', '/api/inventoryItems', [
            'playersMax' => 5
        ]);
        $response->assertJsonMissingValidationErrors('playersMin');
        $response->assertJsonMissingValidationErrors('playersMax');
    }

    /**
     * Tests correct players counts validation.
     *
     * @return void
     */
    public function testCorrectPlayersCountsValidation()
    {
        $response = $this->json('POST', '/api/inventoryItems', [
            'playersMin' => 5,
            'playersMax' => 20
        ]);
        $response->assertJsonMissingValidationErrors('playersMin');
        $response->assertJsonMissingValidationErrors('playersMax');
    }
}

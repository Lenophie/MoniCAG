<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PlayersValidationTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp()
    {
        Parent::setUp();
        $admin = factory(User::class)->state('admin')->create();
        $this->actingAs($admin);
    }

    /**
     * Tests players counts nullability.
     *
     * @return void
     */
    public function testPlayersCountsNullability()
    {
        $response = $this->json('POST', '/edit-inventory', [
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
        $response = $this->json('POST', '/edit-inventory', [
            'playersMin' => 'I am a string',
            'playersMax' => 'I am a string'
        ]);
        $response->assertJsonValidationErrors('playersMin');
        $response->assertJsonValidationErrors('playersMax');
        $response = $this->json('POST', '/edit-inventory', [
            'playersMin' => [],
            'playersMax' => []
        ]);
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
        $response = $this->json('POST', '/edit-inventory', [
            'playersMin' => -1,
            'playersMax' => -1
        ]);
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
        $response = $this->json('POST', '/edit-inventory', [
            'playersMin' => 20,
            'playersMax' => 5
        ]);
        $response->assertJsonValidationErrors('playersMax');
    }

    /**
     * Tests single players count filling validation.
     *
     * @return void
     */
    public function testSinglePlayersCountFillingValidation()
    {
        $response = $this->json('POST', '/edit-inventory', [
            'playersMin' => 5
        ]);
        $response->assertJsonMissingValidationErrors('playersMin');
        $response->assertJsonMissingValidationErrors('playersMax');
        $response = $this->json('POST', '/edit-inventory', [
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
        $response = $this->json('POST', '/edit-inventory', [
            'playersMin' => 5,
            'playersMax' => 20
        ]);
        $response->assertJsonMissingValidationErrors('playersMin');
        $response->assertJsonMissingValidationErrors('playersMax');
    }
}

<?php

namespace Tests\Feature;

use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use phpDocumentor\Reflection\Types\String_;
use Tests\TestCase;

class GuaranteeValidationTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp()
    {
        Parent::setUp();
        $lender = factory(User::class)->state('lender')->create();
        $this->actingAs($lender);
    }

    /**
     * Tests guarantee requirement validation.
     *
     * @return void
     */
    public function testGuaranteeRequirement()
    {
        $response = $this->json('POST', '/new-borrowing', []);
        $response->assertJsonValidationErrors('guarantee');
    }

    /**
     * Tests guarantee numeric validation.
     *
     * @return void
     */
    public function testGuaranteeNumericValidation()
    {
        $response = $this->json('POST', '/new-borrowing', [
            'guarantee' => 'I am a string'
        ]);
        $response->assertJsonValidationErrors('guarantee');
        $response = $this->json('POST', '/new-borrowing', [
            'guarantee' => null
        ]);
        $response->assertJsonValidationErrors('guarantee');
        $response = $this->json('POST', '/new-borrowing', [
            'guarantee' => true
        ]);
        $response->assertJsonValidationErrors('guarantee');
        $response = $this->json('POST', '/new-borrowing', [
            'guarantee' => array()
        ]);
        $response->assertJsonValidationErrors('guarantee');
    }

    /**
     * Tests guarantee integer validation.
     *
     * @return void
     */
    public function testGuaranteeIntegerValidation()
    {
        $response = $this->json('POST', '/new-borrowing', [
            'guarantee' => 10
        ]);
        $response->assertJsonMissingValidationErrors('guarantee');
    }

    /**
     * Tests guarantee decimal validation.
     *
     * @return void
     */
    public function testGuaranteeDecimalValidation()
    {
        $response = $this->json('POST', '/new-borrowing', [
            'guarantee' => 10.5
        ]);
        $response->assertJsonMissingValidationErrors('guarantee');
    }

    /**
     * Tests guarantee two decimals validation.
     *
     * @return void
     */
    public function testGuaranteeTwoDecimalsValidation()
    {
        $response = $this->json('POST', '/new-borrowing', [
            'guarantee' => 10.75
        ]);
        $response->assertJsonMissingValidationErrors('guarantee');
    }

    /**
     * Tests guarantee three decimals rejection.
     *
     * @return void
     */
    public function testGuaranteeThreeDecimalsRejection()
    {
        $response = $this->json('POST', '/new-borrowing', [
            'guarantee' => 10.865
        ]);
        $response->assertJsonValidationErrors('guarantee');
    }

    /**
     * Tests negative guarantee rejection.
     *
     * @return void
     */
    public function testNegativeGuaranteeRejection()
    {
        $response = $this->json('POST', '/new-borrowing', [
            'guarantee' => -10.75
        ]);
        $response->assertJsonValidationErrors('guarantee');
    }

    /**
     * Tests zero guarantee validation.
     *
     * @return void
     */
    public function testZeroGuaranteeValidation()
    {
        $response = $this->json('POST', '/new-borrowing', [
            'guarantee' => 0
        ]);
        $response->assertJsonMissingValidationErrors('guarantee');
    }
}

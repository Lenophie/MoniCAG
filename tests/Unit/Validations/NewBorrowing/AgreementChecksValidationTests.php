<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AgreementChecksValidationTests extends TestCase
{
    use DatabaseTransactions;

    protected function setUp()
    {
        Parent::setUp();
        $lender = factory(User::class)->state('lender')->create();
        $this->actingAs($lender);
    }

    /**
     * Tests agreement check 1 requirement.
     *
     * @return void
     */
    public function testAgreementCheck1Requirement()
    {
        $response = $this->json('POST', '/new-borrowing', []);
        $response->assertJsonValidationErrors('agreementCheck1');
    }

    /**
     * Tests agreement check 1 acceptation validation.
     *
     * @return void
     */
    public function testAgreementCheck1AcceptationValidation()
    {
        $response = $this->json('POST', '/new-borrowing', [
            'agreementCheck1' => 'on'
        ]);
        $response->assertJsonMissingValidationErrors('agreementCheck1');
    }

    /**
     * Tests agreement check 1 refusal rejection.
     *
     * @return void
     */
    public function testAgreementCheck1RefusalRejection()
    {
        $response = $this->json('POST', '/new-borrowing', [
            'agreementCheck1' => 'off'
        ]);
        $response->assertJsonValidationErrors('agreementCheck1');
    }

    /**
     * Tests agreement check 2 requirement validation.
     *
     * @return void
     */
    public function testAgreementCheck2Requirement()
    {
        $response = $this->json('POST', '/new-borrowing', []);
        $response->assertJsonValidationErrors('agreementCheck2');
    }

    /**
     * Tests agreement check 2 acceptation validation.
     *
     * @return void
     */
    public function testAgreementCheck2AcceptationValidation()
    {
        $response = $this->json('POST', '/new-borrowing', [
            'agreementCheck2' => 'on'
        ]);
        $response->assertJsonMissingValidationErrors('agreementCheck2');
    }

    /**
     * Tests agreement check 2 refusal rejection.
     *
     * @return void
     */
    public function testAgreementCheck2RefusalRejection()
    {
        $response = $this->json('POST', '/new-borrowing', [
            'agreementCheck2' => 'off'
        ]);
        $response->assertJsonValidationErrors('agreementCheck2');
    }
}

<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BorrowerEmailValidationTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    protected function setUp()
    {
        Parent::setUp();
        $lender = factory(User::class)->state('lender')->create();
        $this->actingAs($lender);
        $this->faker->seed(0);
    }

    /**
     * Tests borrower email requirement validation.
     *
     * @return void
     */
    public function testBorrowerEmailRequirementValidation()
    {
        $response = $this->json('POST', '/new-borrowing', []);
        $response->assertJsonValidationErrors('borrowerEmail');
    }

    /**
     * Tests unregistered borrower email rejection.
     *
     * @return void
     */
    public function testUnregisteredBorrowerEmailRejection()
    {
        $response = $this->json('POST', '/new-borrowing', [
            'borrowerEmail' => $this->faker->unique()->safeEmail
        ]);
        $response->assertJsonValidationErrors('borrowerEmail');
    }

    /**
     * Tests registered borrower email validation.
     *
     * @return void
     */
    public function testRegisteredBorrowerEmailValidation()
    {
        $user = factory(User::class)->create();
        $response = $this->json('POST', '/new-borrowing', [
            'borrowerEmail' => $user->email
        ]);
        $response->assertJsonMissingValidationErrors('borrowerEmail');
    }
}

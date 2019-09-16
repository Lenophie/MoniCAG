<?php

use App\Borrowing;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserIdValidationForDeletionTest extends TestCase
{
    use DatabaseTransactions;

    private $admin;

    protected function setUp(): void
    {
        Parent::setUp();
        $this->admin = factory(User::class)->state('admin')->create();
        $this->actingAs($this->admin, 'api');
    }


    /**
     * Tests user id not an integer rejection.
     *
     * @return void
     */
    public function testUserIdNotAnIntegerRejection()
    {
        $response = $this->json('DELETE', route('users.destroy', 'string'), []);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * Tests non existent user rejection.
     *
     * @return void
     */
    public function testNonExistentUserRejection()
    {
        $nonExistentUserID = factory(User::class, 5)->create()->max('id') + 1;

        $response = $this->json('DELETE', route('users.destroy', $nonExistentUserID), []);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * Tests deletion of other admin rejection.
     *
     * @return void
     */
    public function testDeletionOfOtherAdminRejection()
    {
        $otherAdmin = factory(User::class)->state('admin')->create();
        $response = $this->json('DELETE', route('users.destroy', $otherAdmin->id), []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests deletion of super admin rejection.
     *
     * @return void
     */
    public function testDeletionOfSuperAdminRejection()
    {
        $superAdmin = factory(User::class)->state('super-admin')->create();
        $response = $this->json('DELETE', route('users.destroy', $superAdmin->id), []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests deletion of lender validation.
     *
     * @return void
     */
    public function testDeletionOfLenderValidation()
    {
        $user = factory(User::class)->state('lender')->create();
        $response = $this->json('DELETE', route('users.destroy', $user->id), []);
        $response->assertJsonMissingValidationErrors("user");
    }

    /**
     * Tests deletion of basic user validation.
     *
     * @return void
     */
    public function testDeletionOfBasicUserValidation()
    {
        $user = factory(User::class)->create();
        $response = $this->json('DELETE', route('users.destroy', $user->id), []);
        $response->assertJsonMissingValidationErrors("user");
    }

    /**
     * Tests deletion of self validation.
     *
     * @return void
     */
    public function testDeletionOfSelfValidation()
    {
        $response = $this->json('DELETE', route('users.destroy', $this->admin->id), []);
        $response->assertJsonMissingValidationErrors("user");
    }

    /**
     * Tests the rejection of the deletion of a user involved in an ongoing borrowing.
     *
     * @return void
     */
    public function testUserInvolvedInACurrentBorrowingDeletionRejection() {
        $borrowing = factory(Borrowing::class)->create();
        $borrower = $borrowing->borrower()->first();
        $initialLender = $borrowing->initialLender()->first();

        $response = $this->json('DELETE', route('users.destroy', $borrower->id), []);
        $response->assertJsonValidationErrors('user');
        $response = $this->json('DELETE', route('users.destroy', $initialLender->id), []);
        $response->assertJsonValidationErrors('user');
    }
}

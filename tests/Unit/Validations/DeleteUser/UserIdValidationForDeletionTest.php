<?php

use App\Borrowing;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserIdValidationForDeletionTest extends TestCase
{
    use DatabaseTransactions;

    private $admin;

    protected function setUp(): void
    {
        Parent::setUp();
        $admin = factory(User::class)->state('admin')->create();
        $this->actingAs($admin, 'api');
        $this->admin = $admin;
    }


    /**
     * Tests user id not an integer rejection.
     *
     * @return void
     */
    public function testUserIdNotAnIntegerRejection()
    {
        $response = $this->json('DELETE', '/api/users/string', []);
        $response->assertStatus(404);
    }

    /**
     * Tests non existent user rejection.
     *
     * @return void
     */
    public function testNonExistentUserRejection()
    {
        $users = factory(User::class, 5)->create();
        $usersIDs = [];
        foreach($users as $user) array_push($usersIDs, $user->id);
        $nonExistentUserID = max($usersIDs) + 1;

        $response = $this->json('DELETE', '/api/users/' . $nonExistentUserID, []);
        $response->assertStatus(404);
    }

    /**
     * Tests modification of other admin rejection.
     *
     * @return void
     */
    public function testModificationOfOtherAdminRejection()
    {
        $otherAdmin = factory(User::class)->state('admin')->create();
        $response = $this->json('DELETE', '/api/users/' . $otherAdmin->id, []);
        $response->assertJsonValidationErrors('user');
    }

    /**
     * Tests modification of lender validation.
     *
     * @return void
     */
    public function testModificationOfLenderValidation()
    {
        $user = factory(User::class)->state('lender')->create();
        $response = $this->json('DELETE', '/api/users/' . $user->id, []);
        $response->assertStatus(200);
    }

    /**
     * Tests modification of basic user validation.
     *
     * @return void
     */
    public function testModificationOfBasicUserValidation()
    {
        $user = factory(User::class)->create();
        $response = $this->json('DELETE', '/api/users/' . $user->id, []);
        $response->assertStatus(200);
    }

    /**
     * Tests modification of self validation.
     *
     * @return void
     */
    public function testModificationOfSelfValidation()
    {
        $response = $this->json('DELETE', '/api/users/' . $this->admin->id, []);
        $response->assertStatus(200);
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

        $response = $this->json('DELETE', '/api/users/' . $borrower->id, []);
        $response->assertJsonValidationErrors('user');
        $response = $this->json('DELETE', '/api/users/' . $initialLender->id, []);
        $response->assertJsonValidationErrors('user');
    }
}

<?php

use App\Borrowing;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteUserRequestTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    protected function setUp()
    {
        Parent::setUp();
        $this->faker->seed(0);
        $admin = factory(User::class)->state('admin')->create();
        $this->actingAs($admin, 'api');
    }

    /**
     * Tests delete user request.
     *
     * @return void
     */
    public function testDeleteUserRequest()
    {
        // Fields values setup
        $users = factory(User::class, 3)->create();

        // Delete user
        $response = $this->json('DELETE', '/api/users/' . $users[1]->id, []);

        // Check response
        $response->assertStatus(200);

        // Check user deletion in database
        $this->assertDatabaseMissing('users', [
            'id' => $users[1]->id
        ]);

        // Check other users unaffected
        $this->assertDatabaseHas('users', [
            'id' => $users[0]->id
        ]);
        $this->assertDatabaseHas('users', [
            'id' => $users[2]->id
        ]);
    }

    /**
     * Tests delete user request borrowing cascading.
     *
     * @return void
     */
    public function testDeleteUserRequestBorrowingCascading()
    {
        // Fields values setup
        $user = factory(User::class)->create();
        $borrowingOfUser = factory(Borrowing::class)->state('finished')->create([
            'borrower_id' => $user->id
        ]);
        $borrowingAllowedByUser = factory(Borrowing::class)->state('finished')->create([
            'initial_lender_id' => $user->id
        ]);
        $borrowingReturnedByUser = factory(Borrowing::class)->state('finished')->create([
            'return_lender_id' => $user->id
        ]);

        // Delete user
        $this->json('DELETE', '/api/users/' . $user->id, []);

        // Check cascading
        $this->assertDatabaseHas('borrowings', [
            'id' => $borrowingOfUser->id,
            'borrower_id' => null
        ]);
        $this->assertDatabaseHas('borrowings', [
            'id' => $borrowingAllowedByUser->id,
            'initial_lender_id' => null
        ]);
        $this->assertDatabaseHas('borrowings', [
            'id' => $borrowingReturnedByUser->id,
            'return_lender_id' => null
        ]);
    }
}

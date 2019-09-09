<?php

use App\Borrowing;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class DeleteUserRequestTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    private $adminPassword;

    protected function setUp(): void
    {
        Parent::setUp();
        $this->faker->seed(0);

        // Setup admin
        $this->adminPassword = $this->faker()->unique()->password;
        $admin = factory(User::class)->state('admin')->create([
            'password' => bcrypt($this->adminPassword)
        ]);
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
        $response = $this->json('DELETE', route('users.destroy', $users[1]->id), [
            'password' => $this->adminPassword
        ]);

        // Check response
        $response->assertStatus(Response::HTTP_OK);

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
        $this->json('DELETE', route('users.destroy', $user->id), [
            'password' => $this->adminPassword
        ]);

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

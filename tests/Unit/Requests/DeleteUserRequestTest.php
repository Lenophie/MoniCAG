<?php

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
        $admin = factory(User::class)->state('admin')->create();
        $this->actingAs($admin);
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

        // Patch user
        $response = $this->json('DELETE', '/edit-users', [
            'userId' => $users[1]->id
        ]);

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
}

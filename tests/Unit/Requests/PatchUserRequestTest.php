<?php

use App\User;
use App\UserRole;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PatchUserRequestTest extends TestCase
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
     * Tests patch user request.
     *
     * @return void
     */
    public function testPatchUserRequest()
    {
        // Fields values setup
        $userToPatch = factory(User::class)->create();
        $newRole = UserRole::LENDER;

        // Patch user
        $response = $this->json('PATCH', '/edit-users', [
            'userId' => $userToPatch->id,
            'role' => $newRole
        ]);

        // Check response
        $response->assertStatus(200);

        // Check user patching in database
        $this->assertDatabaseHas('users', [
            'id' => $userToPatch->id,
            'role_id' => $newRole
        ]);
    }
}

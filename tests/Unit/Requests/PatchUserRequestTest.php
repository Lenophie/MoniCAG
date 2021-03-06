<?php

use App\User;
use App\UserRole;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class PatchUserRequestTest extends TestCase
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
        $response = $this->json('PATCH', route('users.changeRole', $userToPatch->id), [
            'password' => $this->adminPassword,
            'role' => $newRole
        ]);

        // Check response
        $response->assertStatus(Response::HTTP_OK);

        // Check user patching in database
        $this->assertDatabaseHas('users', [
            'id' => $userToPatch->id,
            'role_id' => $newRole
        ]);
    }
}

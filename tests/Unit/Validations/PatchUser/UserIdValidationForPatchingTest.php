<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserIdValidationForPatchingTest extends TestCase
{
    use DatabaseTransactions;

    private $admin;

    protected function setUp()
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
        $response = $this->json('PATCH', '/api/users/string/role', []);
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

        $response = $this->json('PATCH', '/api/users/' . $nonExistentUserID . '/role', []);
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
        $response = $this->json('PATCH', '/api/users/' . $otherAdmin->id . '/role', []);
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
        $response = $this->json('PATCH', '/api/users/' . $user->id . '/role', []);
        $response->assertJsonMissingValidationErrors('user');
    }

    /**
     * Tests modification of basic user validation.
     *
     * @return void
     */
    public function testModificationOfBasicUserValidation()
    {
        $user = factory(User::class)->create();
        $response = $this->json('PATCH', '/api/users/' . $user . '/role', []);
        $response->assertJsonMissingValidationErrors('user');
    }

    /**
     * Tests modification of self validation.
     *
     * @return void
     */
    public function testModificationOfSelfValidation()
    {
        $response = $this->json('PATCH', '/api/users/' . $this->admin->id . '/role', []);
        $response->assertJsonMissingValidationErrors('user');
    }
}

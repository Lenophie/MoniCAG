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
        $this->actingAs($admin);
        $this->admin = $admin;
    }

    /**
     * Tests user id requirement.
     *
     * @return void
     */
    public function testUserIdRequirementValidation()
    {
        $response = $this->json('PATCH', '/edit-users', []);
        $response->assertJsonValidationErrors('userId');
    }

    /**
     * Tests user id not an integer rejection.
     *
     * @return void
     */
    public function testUserIdNotAnIntegerRejection()
    {
        $response = $this->json('PATCH', '/edit-users', [
            'userId' => 'I am a string'
        ]);
        $response->assertJsonValidationErrors('userId');
        $response = $this->json('PATCH', '/edit-users', [
            'userId' => null
        ]);
        $response->assertJsonValidationErrors('userId');
        $response = $this->json('PATCH', '/edit-users', [
            'userId' => [0]
        ]);
        $response->assertJsonValidationErrors('userId');
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

        $response = $this->json('PATCH', '/edit-users', [
            'userId' => $nonExistentUserID
        ]);
        $response->assertJsonValidationErrors('userId');
    }

    /**
     * Tests modification of other admin rejection.
     *
     * @return void
     */
    public function testModificationOfOtherAdminRejection()
    {
        $otherAdmin = factory(User::class)->state('admin')->create();
        $response = $this->json('PATCH', '/edit-users', [
            'userId' => $otherAdmin->id
        ]);
        $response->assertJsonValidationErrors('userId');
    }

    /**
     * Tests modification of lender validation.
     *
     * @return void
     */
    public function testModificationOfLenderValidation()
    {
        $user = factory(User::class)->state('lender')->create();
        $response = $this->json('PATCH', '/edit-users', [
            'userId' => $user->id
        ]);
        $response->assertJsonMissingValidationErrors('userId');
    }

    /**
     * Tests modification of basic user validation.
     *
     * @return void
     */
    public function testModificationOfBasicUserValidation()
    {
        $user = factory(User::class)->create();
        $response = $this->json('PATCH', '/edit-users', [
            'userId' => $user->id
        ]);
        $response->assertJsonMissingValidationErrors('userId');
    }

    /**
     * Tests modification of self validation.
     *
     * @return void
     */
    public function testModificationOfSelfValidation()
    {
        $response = $this->json('PATCH', '/edit-users', [
            'userId' => $this->admin->id
        ]);
        $response->assertJsonMissingValidationErrors('userId');
    }
}

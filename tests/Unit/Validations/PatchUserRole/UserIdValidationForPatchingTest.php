<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserIdValidationForPatchingTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    private $admin;
    private $adminPassword;

    protected function setUp(): void
    {
        Parent::setUp();
        $this->adminPassword = $this->faker()->unique()->password;
        $this->admin = factory(User::class)->state('admin')->create([
            'password' => bcrypt($this->adminPassword)
        ]);
        $this->actingAs($this->admin, 'api');
    }

    /**
     * Tests user id not an integer rejection.
     *
     * @return void
     */
    public function testUserIdNotAnIntegerRejection()
    {
        $response = $this->json('PATCH', route('users.changeRole', 'string'), [
            'password' => $this->adminPassword
        ]);
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

        $response = $this->json('PATCH', route('users.changeRole', $nonExistentUserID), [
            'password' => $this->adminPassword
        ]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * Tests modification of other admin rejection.
     *
     * @return void
     */
    public function testModificationOfOtherAdminRejection()
    {
        $otherAdmin = factory(User::class)->state('admin')->create();
        $response = $this->json('PATCH', route('users.changeRole', $otherAdmin->id), [
            'password' => $this->adminPassword
        ]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests modification of lender validation.
     *
     * @return void
     */
    public function testModificationOfLenderValidation()
    {
        $user = factory(User::class)->state('lender')->create();
        $response = $this->json('PATCH', route('users.changeRole', $user->id), [
            'password' => $this->adminPassword
        ]);
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
        $response = $this->json('PATCH', route('users.changeRole', $user->id), [
            'password' => $this->adminPassword
        ]);
        $response->assertJsonMissingValidationErrors('user');

    }

    /**
     * Tests modification of self validation.
     *
     * @return void
     */
    public function testModificationOfSelfValidation()
    {
        $response = $this->json('PATCH', route('users.changeRole', $this->admin->id), [
            'password' => $this->adminPassword
        ]);
        $response->assertJsonMissingValidationErrors('user');

    }
}

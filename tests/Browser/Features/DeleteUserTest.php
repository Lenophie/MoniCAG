<?php

namespace Tests\Browser\Features;

use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\EditUsersPage;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\PagesFromHomeEnum;
use Tests\DuskTestCase;

class DeleteUserTest extends DuskTestCase
{
    use WithFaker;

    private $admin;
    private $adminPassword;
    private $lender;
    private $user;

    protected function setUp(): void {
        Parent::setUp();
        $this->faker->seed(0);
        $this->user = factory(User::class)->create();
        $this->lender = factory(User::class)->state('lender')->create();
        $this->adminPassword = $this->faker()->unique()->password;
        $this->admin = factory(User::class)->state('admin')->create([
            'password' => bcrypt($this->adminPassword)
        ]);
    }

    protected function tearDown(): void {
        User::query()->delete();
    }

    private function doUserDelete($id) {
        $this->browse(function (Browser $browser) use ($id) {
            $browser->loginAs($this->admin)
                ->visit(new HomePage)
                ->navigateTo(PagesFromHomeEnum::EDIT_USERS)
                ->on(new EditUsersPage)
                ->waitForPageLoaded()
                ->clickOnUserDeleteButton($id)
                ->whenAvailable('@userDeletionModal', function (Browser $modal) {
                    $modal->type("password", $this->adminPassword)
                        ->press('@userDeletionConfirmationButton');
                })
                ->waitForReload()
                ->assertPathIs('/');
        });
    }

    public function testDeleteUser() {
        // Go to the edit users page and delete a user
        $this->doUserDelete($this->user->id);

        // Check the record deletion from the database
        $this->assertDatabaseMissing('users', ['id' => $this->user->id]);
    }

    public function testDeleteLender() {
        // Go to the edit users page and delete a lender
        $this->doUserDelete($this->lender->id);

        // Check the record deletion from the database
        $this->assertDatabaseMissing('users', ['id' => $this->lender->id]);
    }

    public function testDeleteSelf() {
        // Go to the edit users page and delete self
        $this->doUserDelete($this->admin->id);

        // Check the record deletion from the database
        $this->assertDatabaseMissing('users', ['id' => $this->admin->id]);
    }
}

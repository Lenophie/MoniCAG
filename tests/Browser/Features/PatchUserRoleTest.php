<?php

namespace Tests\Browser\Features;

use App\User;
use App\UserRole;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\EditUsersPage;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\PagesFromHomeEnum;
use Tests\DuskTestCase;

class PatchUserRoleTest extends DuskTestCase
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

    private function doUserRolePatch($id, $role) {
        $this->browse(function (Browser $browser) use ($id, $role) {
            $browser->loginAs($this->admin)
                ->visit(new HomePage)
                ->navigateTo(PagesFromHomeEnum::EDIT_USERS)
                ->on(new EditUsersPage)
                ->waitForPageLoaded()
                ->clickOnUserButton($id)
                ->whenAvailable('@userRoleUpdateModal', function (Browser $modal) use ($role) {
                    $modal->clickOptionFromRoleDropdown($role)
                        ->type("password", $this->adminPassword)
                        ->press('@userRoleUpdateConfirmationButton');
                })
                ->waitForReload()
                ->assertPathIs('/');
        });
    }

    public function testUserRolePatch() {
        // Go to the edit users page and patch a user's role
        $this->doUserRolePatch($this->user->id, UserRole::ADMINISTRATOR);

        // Check record modification in the database
        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'role_id' => UserRole::ADMINISTRATOR
        ]);
    }

    public function testLenderRolePatch() {
        // Go to the edit users page and patch a lender's role
        $this->doUserRolePatch($this->lender->id, UserRole::ADMINISTRATOR);

        // Check record modification in the database
        $this->assertDatabaseHas('users', [
            'id' => $this->lender->id,
            'role_id' => UserRole::ADMINISTRATOR
        ]);
    }

    public function testPatchSelfRole() {
        // Go to the edit users page and try to patch own role
        $this->doUserRolePatch($this->admin->id, UserRole::NONE);

        // Check record modification in the database
        $this->assertDatabaseHas('users', [
            'id' => $this->admin->id,
            'role_id' => UserRole::NONE
        ]);
    }
}

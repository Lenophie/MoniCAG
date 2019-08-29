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
    private $otherAdmin;
    private $lender;
    private $user;

    protected function setUp(): void {
        Parent::setUp();
        $this->faker->seed(0);
        $user = factory(User::class)->create();
        $this->user = $user;
        $lender = factory(User::class)->state('lender')->create();
        $this->lender = $lender;
        $admin = factory(User::class)->state('admin')->create();
        $this->admin = $admin;
        $otherAdmin = factory(User::class)->state('admin')->create();
        $this->otherAdmin = $otherAdmin;
    }

    protected function tearDown(): void {
        $this->admin->delete();
        $this->otherAdmin->delete();
        $this->lender->delete();
        $this->user->delete();
    }

    public function testPatchUserRole() {
        // Go to the edit users page and patch a user's role
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new HomePage)
                ->navigateTo(PagesFromHomeEnum::EDIT_USERS)
                ->on(new EditUsersPage)
                ->select("#role-{$this->user->id}", UserRole::ADMINISTRATOR)
                ->pressOnConfirmButton($this->user->id)
                ->waitForReload()
                ->assertPathIs('/edit-users');
        });

        // Check record modification in the database
        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'role_id' => UserRole::ADMINISTRATOR
        ]);
    }

    public function testPatchLenderRole() {
        // Go to the edit users page and patch a lender's role
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new HomePage)
                ->navigateTo(PagesFromHomeEnum::EDIT_USERS)
                ->on(new EditUsersPage)
                ->select("#role-{$this->lender->id}", UserRole::ADMINISTRATOR)
                ->pressOnConfirmButton($this->lender->id)
                ->waitForReload()
                ->assertPathIs('/edit-users');
        });

        // Check record modification in the database
        $this->assertDatabaseHas('users', [
            'id' => $this->lender->id,
            'role_id' => UserRole::ADMINISTRATOR
        ]);
    }

    public function testPatchOtherAdminRoleRejection() {
        // Go to the edit users page and try to patch another admin's role
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new HomePage)
                ->navigateTo(PagesFromHomeEnum::EDIT_USERS)
                ->on(new EditUsersPage)
                ->select("#role-{$this->otherAdmin->id}", UserRole::NONE)
                ->pressOnConfirmButton($this->otherAdmin->id)
                ->waitForText(__('validation/updateUserRole.user.unchanged_if_other_admin'));
        });

        // Check record unchanged in the database
        $this->assertDatabaseHas('users', [
            'id' => $this->otherAdmin->id,
            'role_id' => UserRole::ADMINISTRATOR
        ]);
    }

    public function testPatchSelfRole() {
        // Go to the edit users page and try to patch own role
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new HomePage)
                ->navigateTo(PagesFromHomeEnum::EDIT_USERS)
                ->on(new EditUsersPage)
                ->select("#role-{$this->admin->id}", UserRole::NONE)
                ->pressOnConfirmButton($this->admin->id)
                ->waitForReload()
                ->assertPathIs('/');
        });

        // Check record modification in the database
        $this->assertDatabaseHas('users', [
            'id' => $this->admin->id,
            'role_id' => UserRole::NONE
        ]);
    }
}

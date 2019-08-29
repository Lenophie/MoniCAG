<?php

namespace Tests\Browser\Unit;

use App\User;
use App\UserRole;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\EditUsersPage;
use Tests\DuskTestCase;

class EditUsersPageTest extends DuskTestCase
{
    use WithFaker;

    private $admin;
    private $otherAdmin;
    private $users;

    protected function setUp(): void {
        Parent::setUp();
        $this->faker->seed(0);
        $admin = factory(User::class)->state('admin')->create();
        $this->admin = $admin;
        $users = factory(User::class, 5)->create();
        $this->users = $users;
        $otherAdmin = factory(User::class)->state('admin')->create();
        $this->otherAdmin = $otherAdmin;
    }

    protected function tearDown(): void {
        User::query()->delete();
    }

    public function testUsersPresence() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new EditUsersPage);

            foreach ($this->users as $user) {
                $userRowId = "#user-row-{$user->id}";
                $browser->assertPresent($userRowId)
                    ->with($userRowId, function ($userRow) use ($user) {
                        $userRow->assertSeeIn('.name-field', $user->first_name)
                            ->assertSeeIn('.name-field', $user->last_name)
                            ->assertSeeIn('.promotion-field', $user->promotion)
                            ->assertSeeIn('.email-field', $user->email);
                    });
            }
        });
    }

    public function testUserRoleOptionsStatusForOtherAdmins() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new EditUsersPage)
                ->assertEnabled("#role-{$this->otherAdmin->id} option[value='". UserRole::ADMINISTRATOR . "']")
                ->assertDisabled("#role-{$this->otherAdmin->id} option[value='". UserRole::LENDER . "']")
                ->assertDisabled("#role-{$this->otherAdmin->id} option[value='". UserRole::NONE . "']");
        });
    }

    public function testUserRoleOptionsStatusForOtherUsers() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new EditUsersPage)
                ->assertEnabled("#role-{$this->users[3]->id} option[value='". UserRole::ADMINISTRATOR . "']")
                ->assertEnabled("#role-{$this->users[3]->id} option[value='". UserRole::LENDER . "']")
                ->assertEnabled("#role-{$this->users[3]->id} option[value='". UserRole::NONE . "']");
        });
    }

    public function testUserRoleOptionsStatusForSelf() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new EditUsersPage)
                ->assertEnabled("#role-{$this->admin->id} option[value='". UserRole::ADMINISTRATOR . "']")
                ->assertEnabled("#role-{$this->admin->id} option[value='". UserRole::LENDER . "']")
                ->assertEnabled("#role-{$this->admin->id} option[value='". UserRole::NONE . "']");
        });
    }
}

<?php

namespace Tests\Browser\Unit;

use App\User;
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
        $this->admin = factory(User::class)->state('admin')->create();
        $this->users = factory(User::class, 5)->create();
        $this->otherAdmin = factory(User::class)->state('admin')->create();
        $this->superAdmin = factory(User::class)->state('super-admin')->create();
    }

    protected function tearDown(): void {
        User::query()->delete();
    }

    public function testUsersPresence() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new EditUsersPage)
                ->waitForPageLoaded();

            foreach ($this->users as $user) {
                $browser->assertSee($user->first_name)
                    ->assertSee($user->last_name)
                    ->clickOnUserButton($user->id)
                    ->whenAvailable('@userRoleUpdateModal', function (Browser $modal) use ($user) {
                        $modal->assertSee($user->promotion)
                            ->click('.delete');
                    });
            }

            $browser->assertDontSee($this->superAdmin->first_name)
                ->assertDontSee($this->superAdmin->last_name);
        });
    }

    public function testOtherAdminsButtonsDisabled() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new EditUsersPage)
                ->waitForPageLoaded()
                ->clickOnUserButton($this->otherAdmin->id)
                ->pause(1000)
                ->assertMissing('@userRoleUpdateModal');
        });
    }

    public function testOtherUsersButtonsEnabled() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new EditUsersPage)
                ->waitForPageLoaded()
                ->clickOnUserButton($this->users[1]->id)
                ->pause(1000)
                ->assertPresent('@userRoleUpdateModal');
        });
    }

    public function testOwnButtonEnabled() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new EditUsersPage)
                ->waitForPageLoaded()
                ->clickOnUserButton($this->admin->id)
                ->pause(1000)
                ->assertPresent('@userRoleUpdateModal');
        });
    }
}

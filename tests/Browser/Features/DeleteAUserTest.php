<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\EditUsersPage;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\PagesFromHomeEnum;
use Tests\DuskTestCase;

class DeleteAUserTest extends DuskTestCase
{
    use WithFaker;

    private $admin;
    private $otherAdmin;
    private $users;

    protected function setUp(): void {
        Parent::setUp();
        $this->faker->seed(0);
        $users = factory(User::class, 5)->create();
        $this->users = $users;
        $admin = factory(User::class)->state('admin')->create();
        $this->admin = $admin;
        $otherAdmin = factory(User::class)->state('admin')->create();
        $this->otherAdmin = $otherAdmin;
    }

    protected function tearDown(): void {
        $this->admin->delete();
        $this->otherAdmin->delete();
        foreach ($this->users as $user) $user->delete();
    }

    public function testDeleteAUser() {
        // Go to the edit users page and delete a user
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new HomePage)
                ->navigateTo(PagesFromHomeEnum::EDIT_USERS)
                ->on(new EditUsersPage)
                ->pressOnDeleteUserButton($this->users[3]->id)
                ->waitForReload()
                ->assertPathIs('/edit-users');
        });

        // Check the record deletion from the database
        $this->assertDatabaseMissing('users', ['id' => $this->users[3]->id]);

        // Check other records unaffected
        foreach ([0, 1, 2, 4] as $i) $this->assertDatabaseHas('users', ['id' => $this->users[$i]->id]);
    }

    public function testRejectedDeleteAnotherAdmin() {
        // Go to the edit users page and try to delete another admin
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new HomePage)
                ->navigateTo(PagesFromHomeEnum::EDIT_USERS)
                ->on(new EditUsersPage)
                ->pressOnDeleteUserButton($this->otherAdmin->id)
                ->waitForText(__('validation/deleteUser.user.unchanged_if_other_admin'));
        });

        // Check record unaffected
        $this->assertDatabaseHas('users', ['id' => $this->otherAdmin->id]);
    }
}

<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\AccountPage;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\PagesFromHomeEnum;
use Tests\DuskTestCase;

class DeleteAccountTest extends DuskTestCase
{
    use WithFaker;

    private $userToDelete;
    private $otherUsers;
    private $userToDeletePassword;

    protected function setUp(): void {
        Parent::setUp();
        $this->faker->seed(0);
        $userToDeletePassword = $this->faker->unique()->password;
        $this->userToDeletePassword = $userToDeletePassword;
        $this->userToDelete = factory(User::class)->create([
            'password' => bcrypt($userToDeletePassword)
        ]);
        $otherUsers = factory(User::class, 3)->create();
        $this->otherUsers = $otherUsers;
    }

    protected function tearDown(): void {
        $this->userToDelete->delete();
        foreach ($this->otherUsers as $user) $user->delete();
    }

    public function testDeleteAccount() {
        // Go to the personal space and delete account
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->userToDelete)
                ->visit(new HomePage())
                ->navigateTo(PagesFromHomeEnum::ACCOUNT)
                ->on(new AccountPage())
                ->openAccountDeletionModal()
                ->whenAvailable('@accountDeletionModal', function ($modal) {
                    $modal->type('password', $this->userToDeletePassword)
                        ->click('@accountDeletionConfirmationButton');
                })
                ->waitForReload()
                ->assertPathIs('/');
        });

        // Check the user deletion from the database
        $this->assertDatabaseMissing('users', ['id' => $this->userToDelete->id]);

        // Check other records unaffected
        foreach ($this->otherUsers as $user) $this->assertDatabaseHas('users', ['id' => $user->id]);
    }
}

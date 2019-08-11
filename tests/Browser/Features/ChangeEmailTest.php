<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\AccountPage;
use Tests\Browser\Pages\ChangeEmailPage;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\PagesFromHomeEnum;
use Tests\DuskTestCase;

class ChangeEmailTest extends DuskTestCase
{
    use WithFaker;

    private $user;
    private $userPassword;
    private $userEmail;

    protected function setUp(): void {
        Parent::setUp();
        $this->faker->seed(0);
        $userPassword = $this->faker->unique()->password;
        $userEmail = $this->faker->unique()->safeEmail;
        $this->userPassword = $userPassword;
        $this->userEmail = $userEmail;
        $this->user = factory(User::class)->create([
            'email' => $userEmail,
            'password' => bcrypt($userPassword)
        ]);
    }

    protected function tearDown(): void {
        $this->user->delete();
    }

    public function testChangeEmail() {
        $newEmail = $this->faker->unique()->safeEmail;

        // Go to the personal space and change account email
        $this->browse(function (Browser $browser) use ($newEmail) {
            $browser->loginAs($this->user)
                ->visit(new HomePage())
                ->navigateTo(PagesFromHomeEnum::ACCOUNT)
                ->on(new AccountPage())
                ->waitForPageLoaded()
                ->navigateToModifyEmailPage()
                ->on(new ChangeEmailPage())
                ->type('password', $this->userPassword)
                ->type('email', $newEmail)
                ->click('@changeEmailConfirmationButton')
                ->assertPathIs('/');
        });

        // Check the user email change in the database
        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'email' => $newEmail
        ]);
    }
}

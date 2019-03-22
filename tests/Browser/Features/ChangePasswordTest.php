<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\AccountPage;
use Tests\Browser\Pages\ChangePasswordPage;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\PagesFromHomeEnum;
use Tests\DuskTestCase;

class ChangePasswordTest extends DuskTestCase
{
    use WithFaker;

    private $user;
    private $userPassword;

    protected function setUp() {
        Parent::setUp();
        $userPassword = $this->faker->unique()->password;
        $this->userPassword = $userPassword;
        $this->user = factory(User::class)->create([
            'password' => bcrypt($userPassword)
        ]);
    }

    protected function tearDown() {
        $this->user->delete();
    }

    public function testChangePassword() {
        $newPassword = $this->faker->unique()->password;

        // Go to the personal space and change account email
        $this->browse(function (Browser $browser) use ($newPassword) {
            $browser->loginAs($this->user)
                ->visit(new HomePage())
                ->navigateTo(PagesFromHomeEnum::ACCOUNT)
                ->on(new AccountPage())
                ->navigateToModifyPasswordPage()
                ->on(new ChangePasswordPage())
                ->type('oldPassword', $this->userPassword)
                ->type('newPassword', $newPassword)
                ->type('newPassword_confirmation', $newPassword)
                ->click('@changePasswordConfirmationButton')
                ->assertPathIs('/');
        });

        // Check password change in the database
        $passwordHashInDB = User::where('id', $this->user->id)->first()->password;
        $this->assertTrue(Hash::check($newPassword, $passwordHashInDB));
    }
}
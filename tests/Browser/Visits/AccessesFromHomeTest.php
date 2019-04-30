<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\PagesFromHomeEnum;
use Tests\DuskTestCase;

class AccessesFromHomeTest extends DuskTestCase
{
    use WithFaker;

    protected function setUp(): void {
        Parent::setUp();
        $this->faker->seed(0);
    }

    public function testAccessToNewBorrowingPage()
    {
        $lender = factory(User::class)->state('lender')->create();

        $this->browse(function (Browser $browser) use ($lender) {
            $browser->loginAs($lender)
                ->visit(new HomePage())
                ->navigateTo(PagesFromHomeEnum::NEW_BORROWING)
                ->assertPathIs('/new-borrowing');
        });

        $lender->delete();
    }

    public function testAccessToEndBorrowingPage()
    {
        $lender = factory(User::class)->state('lender')->create();

        $this->browse(function (Browser $browser) use ($lender) {
            $browser->loginAs($lender)
                ->visit(new HomePage())
                ->navigateTo(PagesFromHomeEnum::END_BORROWING)
                ->assertPathIs('/end-borrowing');
        });

        $lender->delete();
    }

    public function testAccessToBorrowingsHistoryPage()
    {
        $lender = factory(User::class)->state('lender')->create();

        $this->browse(function (Browser $browser) use ($lender) {
            $browser->loginAs($lender)
                ->visit(new HomePage())
                ->navigateTo(PagesFromHomeEnum::BORROWINGS_HISTORY)
                ->assertPathIs('/borrowings-history');
        });

        $lender->delete();
    }

    public function testAccessToViewInventoryPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new HomePage())
                ->navigateTo(PagesFromHomeEnum::VIEW_INVENTORY)
                ->assertPathIs('/view-inventory');
        });
    }

    public function testAccessToEditInventoryPage()
    {
        $admin = factory(User::class)->state('admin')->create();

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit(new HomePage())
                ->navigateTo(PagesFromHomeEnum::EDIT_INVENTORY)
                ->assertPathIs('/edit-inventory');
        });

        $admin->delete();
    }

    public function testAccessToEditUsersPage()
    {
        $admin = factory(User::class)->state('admin')->create();

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit(new HomePage())
                ->navigateTo(PagesFromHomeEnum::EDIT_USERS)
                ->assertPathIs('/edit-users');
        });

        $admin->delete();
    }

    public function testAccessToGithubPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new HomePage())
                ->navigateTo(PagesFromHomeEnum::GITHUB)
                ->assertHostIs('github.com')
                ->assertPathIs('/Lenophie/MoniCAG/');
        });
    }

    public function testAccessToAccountPage()
    {
        $admin = factory(User::class)->state('admin')->create();

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit(new HomePage())
                ->navigateTo(PagesFromHomeEnum::ACCOUNT)
                ->assertPathIs('/account');
        });

        $admin->delete();
    }
}

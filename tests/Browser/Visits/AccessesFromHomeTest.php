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

    public function testAccessToNewBorrowingPage()
    {
        $lender = factory(User::class)->state('lender')->create();

        $this->browse(function (Browser $browser) use ($lender) {
            $browser->loginAs($lender)
                ->visit(new HomePage())
                ->navigateTo(PagesFromHomeEnum::NEW_BORROWING)
                ->assertPathIs('/new-borrowing');
        });
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
        $user = factory(User::class)->state('admin')->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(new HomePage())
                ->navigateTo(PagesFromHomeEnum::EDIT_INVENTORY)
                ->assertPathIs('/edit-inventory');
        });
    }

    public function testAccessToEditUsersPage()
    {
        $user = factory(User::class)->state('admin')->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(new HomePage())
                ->navigateTo(PagesFromHomeEnum::EDIT_USERS)
                ->assertPathIs('/edit-users');
        });
    }
}

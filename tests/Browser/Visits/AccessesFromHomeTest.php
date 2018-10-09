<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\HomePage;
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
                ->navigateTo('new-borrowing')
                ->assertPathIs('/new-borrowing');
        });
    }

    public function testAccessToEndBorrowingPage()
    {
        $lender = factory(User::class)->state('lender')->create();

        $this->browse(function (Browser $browser) use ($lender) {
            $browser->loginAs($lender)
                ->visit(new HomePage())
                ->navigateTo('end-borrowing')
                ->assertPathIs('/end-borrowing');
        });
    }

    public function testAccessToBorrowingsHistoryPage()
    {
        $lender = factory(User::class)->state('lender')->create();

        $this->browse(function (Browser $browser) use ($lender) {
            $browser->loginAs($lender)
                ->visit(new HomePage())
                ->navigateTo('borrowings-history')
                ->assertPathIs('/borrowings-history');
        });
    }

    public function testAccessToViewInventoryPage()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(new HomePage())
                ->navigateTo('view-inventory')
                ->assertPathIs('/view-inventory');
        });
    }

    public function testAccessToEditInventoryPage()
    {
        $user = factory(User::class)->state('admin')->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(new HomePage())
                ->navigateTo('edit-inventory')
                ->assertPathIs('/edit-inventory');
        });
    }

    public function testAccessToEditUsersPage()
    {
        $user = factory(User::class)->state('admin')->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(new HomePage())
                ->navigateTo('edit-users')
                ->assertPathIs('/edit-users');
        });
    }
}

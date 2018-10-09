<?php

namespace Tests\Browser;

use App\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PagesVisitsAsAdminTest extends DuskTestCase
{
    public function testNewBorrowingPageVisit()
    {
        $user = factory(User::class)->state('admin')->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/new-borrowing')
                ->assertPathIs('/new-borrowing')
                ->assertSee(__('messages.titles.perform_borrowing'));
        });
    }

    public function testEndBorrowingPageVisit()
    {
        $user = factory(User::class)->state('admin')->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/end-borrowing')
                ->assertPathIs('/end-borrowing')
                ->assertSee(__('messages.titles.retrieve_borrowing'));
        });
    }

    public function testBorrowingsHistoryPageVisit()
    {
        $user = factory(User::class)->state('admin')->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/borrowings-history')
                ->assertPathIs('/borrowings-history')
                ->assertSee(__('messages.titles.borrowings_history'));
        });
    }

    public function testViewInventoryPageVisit()
    {
        $user = factory(User::class)->state('admin')->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/view-inventory')
                ->assertPathIs('/view-inventory')
                ->assertSee(__('messages.titles.inventory'));
        });
    }

    public function testEditInventoryPageVisit()
    {
        $user = factory(User::class)->state('admin')->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/edit-inventory')
                ->assertPathIs('/edit-inventory')
                ->assertSee(__('messages.titles.edit_inventory'));
        });
    }

    public function testEditUsersPageVisit()
    {
        $user = factory(User::class)->state('admin')->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/edit-users')
                ->assertPathIs('/edit-users')
                ->assertSee(__('messages.titles.edit_users'));
        });
    }
}

<?php

namespace Tests\Browser;

use App\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PagesVisitsAsUserTest extends DuskTestCase
{
    public function testNewBorrowingPageVisit()
    {
        $user = factory(User::class)->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/new-borrowing')
                ->assertPathIs('/new-borrowing')
                ->assertSee(403);
        });
    }

    public function testEndBorrowingPageVisit()
    {
        $user = factory(User::class)->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/end-borrowing')
                ->assertPathIs('/end-borrowing')
                ->assertSee(403);;
        });
    }

    public function testBorrowingsHistoryPageVisit()
    {
        $user = factory(User::class)->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/borrowings-history')
                ->assertPathIs('/borrowings-history')
                ->assertSee(403);;
        });
    }

    public function testViewInventoryPageVisit()
    {
        $user = factory(User::class)->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/view-inventory')
                ->assertPathIs('/view-inventory')
                ->assertSee(__('messages.titles.inventory'));
        });
    }

    public function testEditInventoryPageVisit()
    {
        $user = factory(User::class)->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/edit-inventory')
                ->assertPathIs('/edit-inventory')
                ->assertSee(403);
        });
    }

    public function testEditUsersPageVisit()
    {
        $user = factory(User::class)->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/edit-users')
                ->assertPathIs('/edit-users')
                ->assertSee(403);
        });
    }
}

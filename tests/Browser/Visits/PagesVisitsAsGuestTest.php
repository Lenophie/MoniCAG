<?php

namespace Tests\Browser\Visits;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PagesVisitsAsGuestTest extends DuskTestCase
{
    public function testHomePageVisit()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('MoniCAG');
        });
    }

    public function testNewBorrowingPageVisit()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/new-borrowing')
                ->assertPathIs('/login');
        });
    }

    public function testEndBorrowingPageVisit()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/end-borrowing')
                ->assertPathIs('/login');
        });
    }

    public function testViewInventoryPageVisit()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/view-inventory')
                ->assertPathIs('/view-inventory')
                ->assertSee(__('messages.titles.inventory'));
        });
    }

    public function testEditInventoryPageVisit()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/edit-inventory')
                ->assertPathIs('/login');
        });
    }

    public function testEditUsersPageVisit()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/edit-users')
                ->assertPathIs('/login');
        });
    }

    public function testAccountPageVisit()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/account')
                ->assertPathIs('/login');
        });
    }
}

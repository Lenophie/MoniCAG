<?php

namespace Tests\Browser;

use App\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PagesVisitsAsUserTest extends DuskTestCase
{
    private $user;

    protected function setUp() {
        Parent::setUp();
        $user = factory(User::class)->create();
        $this->user = $user;
    }

    protected function tearDown() {
        $this->user->delete();
    }
    
    public function testNewBorrowingPageVisit()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/new-borrowing')
                ->assertPathIs('/new-borrowing')
                ->assertSee(403);
        });
    }

    public function testEndBorrowingPageVisit()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/end-borrowing')
                ->assertPathIs('/end-borrowing')
                ->assertSee(403);;
        });
    }

    public function testBorrowingsHistoryPageVisit()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/borrowings-history')
                ->assertPathIs('/borrowings-history')
                ->assertSee(403);;
        });
    }

    public function testViewInventoryPageVisit()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/view-inventory')
                ->assertPathIs('/view-inventory')
                ->assertSee(__('messages.titles.inventory'));
        });
    }

    public function testEditInventoryPageVisit()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/edit-inventory')
                ->assertPathIs('/edit-inventory')
                ->assertSee(403);
        });
    }

    public function testEditUsersPageVisit()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/edit-users')
                ->assertPathIs('/edit-users')
                ->assertSee(403);
        });
    }

    public function testAccountPageVisit()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/account')
                ->assertPathIs('/account')
                ->assertSee(__('messages.titles.account'));
        });
    }
}

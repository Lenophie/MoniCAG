<?php

namespace Tests\Browser\Visits;

use App\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PagesVisitsAsSuperAdminTest extends DuskTestCase
{
    private $superAdmin;

    protected function setUp(): void {
        Parent::setUp();
        $this->superAdmin = factory(User::class)->state('super-admin')->create();
    }

    protected function tearDown(): void {
        User::query()->delete();
    }

    public function testNewBorrowingPageVisit()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->superAdmin)
                ->visit('/new-borrowing')
                ->assertPathIs('/new-borrowing')
                ->assertSee(403);
        });
    }

    public function testEndBorrowingPageVisit()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->superAdmin)
                ->visit('/end-borrowing')
                ->assertPathIs('/end-borrowing')
                ->assertSee(403);
        });
    }

    public function testBorrowingsHistoryPageVisit()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->superAdmin)
                ->visit('/borrowings-history')
                ->assertPathIs('/borrowings-history')
                ->assertSee(403);
        });
    }

    public function testViewInventoryPageVisit()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->superAdmin)
                ->visit('/view-inventory')
                ->assertPathIs('/view-inventory')
                ->assertSee(__('messages.titles.inventory'));
        });
    }

    public function testEditInventoryPageVisit()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->superAdmin)
                ->visit('/edit-inventory')
                ->assertPathIs('/edit-inventory')
                ->assertSee(403);
        });
    }

    public function testEditUsersPageVisit()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->superAdmin)
                ->visit('/edit-users')
                ->assertPathIs('/edit-users')
                ->assertSee(__('messages.titles.edit_users'));
        });
    }

    public function testAccountPageVisit()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->superAdmin)
                ->visit('/account')
                ->assertPathIs('/account')
                ->assertSee(__('messages.titles.account'));
        });
    }
}

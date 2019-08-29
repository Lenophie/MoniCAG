<?php

namespace Tests\Browser\Visits;

use App\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PagesVisitsAsAdminTest extends DuskTestCase
{
    private $admin;

    protected function setUp(): void {
        Parent::setUp();
        $admin = factory(User::class)->state('admin')->create();
        $this->admin = $admin;
    }

    protected function tearDown(): void {
        User::query()->delete();
    }

    public function testNewBorrowingPageVisit()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit('/new-borrowing')
                ->assertPathIs('/new-borrowing')
                ->assertSee(__('messages.titles.perform_borrowing'));
        });
    }

    public function testEndBorrowingPageVisit()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit('/end-borrowing')
                ->assertPathIs('/end-borrowing')
                ->assertSee(__('messages.titles.retrieve_borrowing'));
        });
    }

    public function testBorrowingsHistoryPageVisit()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit('/borrowings-history')
                ->assertPathIs('/borrowings-history')
                ->assertSee(__('messages.titles.borrowings_history'));
        });
    }

    public function testViewInventoryPageVisit()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit('/view-inventory')
                ->assertPathIs('/view-inventory')
                ->assertSee(__('messages.titles.inventory'));
        });
    }

    public function testEditInventoryPageVisit()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit('/edit-inventory')
                ->assertPathIs('/edit-inventory')
                ->assertSee(__('messages.titles.edit_inventory'));
        });
    }

    public function testEditUsersPageVisit()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit('/edit-users')
                ->assertPathIs('/edit-users')
                ->assertSee(__('messages.titles.edit_users'));
        });
    }

    public function testAccountPageVisit()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit('/account')
                ->assertPathIs('/account')
                ->assertSee(__('messages.titles.account'));
        });
    }
}

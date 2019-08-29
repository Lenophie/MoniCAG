<?php

namespace Tests\Browser\Visits;

use App\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PagesVisitsAsLenderTest extends DuskTestCase
{
    private $lender;

    protected function setUp(): void {
        Parent::setUp();
        $lender = factory(User::class)->state('lender')->create();
        $this->lender = $lender;
    }

    protected function tearDown(): void {
        User::query()->delete();
    }

    public function testNewBorrowingPageVisit()
    {

        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->lender)
                ->visit('/new-borrowing')
                ->assertPathIs('/new-borrowing')
                ->assertSee(__('messages.titles.perform_borrowing'));
        });
    }

    public function testEndBorrowingPageVisit()
    {

        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->lender)
                ->visit('/end-borrowing')
                ->assertPathIs('/end-borrowing')
                ->assertSee(__('messages.titles.retrieve_borrowing'));
        });
    }

    public function testBorrowingsHistoryPageVisit()
    {

        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->lender)
                ->visit('/borrowings-history')
                ->assertPathIs('/borrowings-history')
                ->assertSee(__('messages.titles.borrowings_history'));
        });
    }

    public function testViewInventoryPageVisit()
    {

        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->lender)
                ->visit('/view-inventory')
                ->assertPathIs('/view-inventory')
                ->assertSee(__('messages.titles.inventory'));
        });
    }

    public function testEditInventoryPageVisit()
    {

        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->lender)
                ->visit('/edit-inventory')
                ->assertPathIs('/edit-inventory')
                ->assertSee(403);
        });
    }

    public function testEditUsersPageVisit()
    {

        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->lender)
                ->visit('/edit-users')
                ->assertPathIs('/edit-users')
                ->assertSee(403);
        });
    }

    public function testAccountPageVisit()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->lender)
                ->visit('/account')
                ->assertPathIs('/account')
                ->assertSee(__('messages.titles.account'));
        });
    }
}

<?php

namespace Tests\Browser;

use App\Borrowing;
use App\User;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\EndBorrowingPage;
use Tests\DuskTestCase;

class EndBorrowingPageUnitTests extends DuskTestCase
{
    public $lender;

    protected function setUp() {
        Parent::setUp();
        $lender = factory(User::class)->state('lender')->create();
        $this->lender = $lender;
    }

    public function testBorrowingsPresence() {
        $borrowings = factory(Borrowing::class, 3)->create();

        $this->browse(function (Browser $browser) use ($borrowings) {
            $browser->loginAs($this->lender)
                ->visit(new EndBorrowingPage());

            foreach ($borrowings as $borrowing) {
                $browser->assertPresent('#borrowings-list-element-' . $borrowing->id);
            }
        });
    }

    public function testLateBorrowingsWarningsPresence()
    {
        $onTimeBorrowing = factory(Borrowing::class)->state('onTime')->create();
        $lateBorrowing = factory(Borrowing::class)->state('late')->create();

        $this->browse(function (Browser $browser) use ($onTimeBorrowing, $lateBorrowing) {
            $browser->loginAs($this->lender)
                ->visit(new EndBorrowingPage())
                ->assertSeeIn('#borrowings-list-element-' . $lateBorrowing->id, __('messages.end_borrowing.late'))
                ->assertDontSeeIn('#borrowings-list-element-' . $onTimeBorrowing->id, __('messages.end_borrowing.late'));
        });
    }

    public function testBorrowingAdditionToCheckoutModal()
    {
        $borrowings = factory(Borrowing::class, 2)->create();

        $this->browse(function (Browser $browser) use ($borrowings) {
            $browser->loginAs($this->lender)
                ->visit(new EndBorrowingPage())
                ->clickOnBorrowingButton($borrowings[0]->id)
                ->click('@returnButton')
                ->whenAvailable('@endBorrowingModal', function ($modal) use ($borrowings) {
                    $modal->assertSee($borrowings[0]->inventoryItem()->first()->name);
                });
        });
    }
}

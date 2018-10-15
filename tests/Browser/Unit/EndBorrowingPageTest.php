<?php

namespace Tests\Browser;

use App\Borrowing;
use App\User;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\EndBorrowingPage;
use Tests\DuskTestCase;

class EndBorrowingPageTest extends DuskTestCase
{
    private $lender;

    protected function setUp() {
        Parent::setUp();
        $lender = factory(User::class)->state('lender')->create();
        $this->lender = $lender;
    }

    protected function tearDown() {
        $this->lender->delete();
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

        foreach ($borrowings as $borrowing) {
            foreach ($borrowing->inventoryItem()->first()->genres()->get() as $genre) $genre->delete();
            $borrowing->inventoryItem()->first()->delete();
            $borrowing->borrower()->first()->delete();
            $borrowing->initialLender()->first()->delete();
            $borrowing->delete();
        }
    }

    public function testLateBorrowingsWarningsPresence()
    {
        $onTimeBorrowing = factory(Borrowing::class)->state('onTime')->create();
        $lateBorrowing = factory(Borrowing::class)->state('late')->create();
        $borrowings = [$onTimeBorrowing, $lateBorrowing];

        $this->browse(function (Browser $browser) use ($onTimeBorrowing, $lateBorrowing) {
            $browser->loginAs($this->lender)
                ->visit(new EndBorrowingPage())
                ->assertSeeIn('#borrowings-list-element-' . $lateBorrowing->id, __('messages.end_borrowing.late'))
                ->assertDontSeeIn('#borrowings-list-element-' . $onTimeBorrowing->id, __('messages.end_borrowing.late'));
        });

        foreach ($borrowings as $borrowing) {
            foreach ($borrowing->inventoryItem()->first()->genres()->get() as $genre) $genre->delete();
            $borrowing->inventoryItem()->first()->delete();
            $borrowing->borrower()->first()->delete();
            $borrowing->initialLender()->first()->delete();
            $borrowing->delete();
        }
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

        foreach ($borrowings as $borrowing) {
            foreach ($borrowing->inventoryItem()->first()->genres()->get() as $genre) $genre->delete();
            $borrowing->inventoryItem()->first()->delete();
            $borrowing->borrower()->first()->delete();
            $borrowing->initialLender()->first()->delete();
            $borrowing->delete();
        }
    }
}

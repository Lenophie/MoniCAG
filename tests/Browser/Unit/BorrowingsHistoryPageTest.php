<?php

namespace Tests\Browser\Unit;

use App\Borrowing;
use App\User;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\BorrowingsHistoryPage;
use Tests\DuskTestCase;

class BorrowingsHistoryPageTest extends DuskTestCase
{
    private $lender;

    protected function setUp(): void {
        Parent::setUp();
        $lender = factory(User::class)->state('lender')->create();
        $this->lender = $lender;
    }

    protected function tearDown(): void {
        $this->lender->delete();
    }

    public function testBorrowingsPresence() {
        $borrowings = factory(Borrowing::class, 3)->create();

        $this->browse(function (Browser $browser) use ($borrowings) {
            $browser->loginAs($this->lender)
                ->visit(new BorrowingsHistoryPage());

            foreach ($borrowings as $borrowing) {
                $rowSelector = "#borrowings-row-{$borrowing->id}";
                $browser->assertPresent($rowSelector);
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

    public function testBorrowingsDetailPresence() {
        $borrowing = factory(Borrowing::class)->state('finished')->create();

        $this->browse(function (Browser $browser) use ($borrowing) {
            $rowSelector = "#borrowings-row-{$borrowing->id}";
            $browser->loginAs($this->lender)
                ->visit(new BorrowingsHistoryPage())
                ->assertSeeIn($rowSelector, $borrowing->inventoryItem()->first()->name)
                ->assertSeeIn($rowSelector, $borrowing->initialLender()->first()->lastName)
                ->assertSeeIn($rowSelector, $borrowing->borrower()->first()->lastName)
                ->assertSeeIn($rowSelector, $borrowing->returnLender()->first()->lastName)
                ->assertSeeIn($rowSelector, $borrowing->guarantee)
                ->assertSeeIn($rowSelector, $borrowing->start_date->format('d/m/Y'))
                ->assertSeeIn($rowSelector, $borrowing->expected_return_date->format('d/m/Y'))
                ->assertSeeIn($rowSelector, $borrowing->return_date->format('d/m/Y'));
        });

        foreach ($borrowing->inventoryItem()->first()->genres()->get() as $genre) $genre->delete();
        $borrowing->inventoryItem()->first()->delete();
        $borrowing->borrower()->first()->delete();
        $borrowing->initialLender()->first()->delete();
        $borrowing->returnLender()->first()->delete();
        $borrowing->delete();
    }

    public function testDeletedUserMessages() {
        $borrowing = factory(Borrowing::class)->state('finished')->create([
            'borrower_id' => null,
            'initial_lender_id' => null,
            'return_lender_id' => null
        ]);

        $this->browse(function (Browser $browser) use ($borrowing) {
            $rowSelector = '#borrowings-row-' . $borrowing->id;
            $browser->loginAs($this->lender)
                ->visit(new BorrowingsHistoryPage())
                ->assertSeeIn("{$rowSelector}>.borrowing-borrower-cell", __('messages.borrowings_history.deleted_user'))
                ->assertSeeIn("{$rowSelector}>.borrowing-initial-lender-cell", __('messages.borrowings_history.deleted_user'))
                ->assertSeeIn("{$rowSelector}>.borrowing-return-lender-cell", __('messages.borrowings_history.deleted_user'));
        });

        foreach ($borrowing->inventoryItem()->first()->genres()->get() as $genre) $genre->delete();
        $borrowing->inventoryItem()->first()->delete();
        $borrowing->delete();
    }
}

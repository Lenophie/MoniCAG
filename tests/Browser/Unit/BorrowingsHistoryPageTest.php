<?php

namespace Tests\Browser\Unit;

use App\Borrowing;
use App\Genre;
use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\BorrowingsHistoryPage;
use Tests\DuskTestCase;

class BorrowingsHistoryPageTest extends DuskTestCase
{
    use WithFaker;

    private $lender;

    protected function setUp(): void {
        Parent::setUp();
        $this->faker->seed(0);
        $lender = factory(User::class)->state('lender')->create();
        $this->lender = $lender;
    }

    protected function tearDown(): void {
        User::query()->delete();
        Borrowing::query()->delete();
        InventoryItem::query()->delete();
        Genre::query()->delete();
    }

    public function testBorrowingsPresence() {
        $borrowings = factory(Borrowing::class, 3)->create();

        $this->browse(function (Browser $browser) use ($borrowings) {
            $browser->loginAs($this->lender)
                ->visit(new BorrowingsHistoryPage);

            foreach ($borrowings as $borrowing) {
                $rowSelector = "#borrowings-row-{$borrowing->id}";
                $browser->assertPresent($rowSelector);
            }
        });
    }

    public function testBorrowingsDetailPresence() {
        $borrowing = factory(Borrowing::class)->state('finished')->create();

        $this->browse(function (Browser $browser) use ($borrowing) {
            $rowSelector = "#borrowings-row-{$borrowing->id}";
            $browser->loginAs($this->lender)
                ->visit(new BorrowingsHistoryPage)
                ->assertSeeIn($rowSelector, $borrowing->inventoryItem()->first()->name)
                ->assertSeeIn($rowSelector, $borrowing->initialLender()->first()->last_name)
                ->assertSeeIn($rowSelector, $borrowing->borrower()->first()->last_name)
                ->assertSeeIn($rowSelector, $borrowing->returnLender()->first()->last_name)
                ->assertSeeIn($rowSelector, $borrowing->guarantee)
                ->assertSeeIn($rowSelector, $borrowing->start_date->format('d/m/Y'))
                ->assertSeeIn($rowSelector, $borrowing->expected_return_date->format('d/m/Y'))
                ->assertSeeIn($rowSelector, $borrowing->return_date->format('d/m/Y'));
        });
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
                ->visit(new BorrowingsHistoryPage)
                ->assertSeeIn("{$rowSelector}>.borrowing-borrower-cell", __('messages.borrowings_history.deleted_user'))
                ->assertSeeIn("{$rowSelector}>.borrowing-initial-lender-cell", __('messages.borrowings_history.deleted_user'))
                ->assertSeeIn("{$rowSelector}>.borrowing-return-lender-cell", __('messages.borrowings_history.deleted_user'));
        });
    }
}

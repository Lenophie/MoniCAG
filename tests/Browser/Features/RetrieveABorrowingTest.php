<?php

namespace Tests\Browser;

use App\Borrowing;
use App\InventoryItemStatus;
use App\User;
use Carbon\Carbon;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\EndBorrowingPage;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\PagesFromHomeEnum;
use Tests\DuskTestCase;

class RetrieveABorrowingTest extends DuskTestCase
{
    protected function setUp() {
        Parent::setUp();
        exec('php artisan migrate:fresh --seed --env=testing');
    }

    public function testReturnBorrowings()
    {
        // Create the necessary preliminary database records
        $borrowings = factory(Borrowing::class, 20)->create();
        $borrowingsToEnd = [$borrowings[8], $borrowings[1], $borrowings[2], $borrowings[19]];
        $lender = factory(User::class)->state('lender')->create();
        $currentDate = Carbon::now();

        $this->browse(function (Browser $browser) use ($borrowingsToEnd, $lender) {
            // Navigate to the end borrowing page
            $browser->loginAs($lender)
                ->visit(new HomePage())
                ->navigateTo(PagesFromHomeEnum::END_BORROWING)
                ->on(new EndBorrowingPage());

            // Select borrowings to end by clicking on them
            foreach ($borrowingsToEnd as $borrowingToEnd) {
                $browser->click('#borrowings-list-element-' . $borrowingToEnd->id);
            }

            // Confirm in the end borrowing modal
            $browser->click('@returnButton')
                ->whenAvailable('@endBorrowingModal', function($modal) {
                    $modal->press('@endBorrowingSubmitButton');
                });

            // Wait for the page reloading
            $browser->waitForReload();
            $browser->assertPathIs('/borrowings-history');
        });

        // Check the database for the changes
        foreach ($borrowingsToEnd as $borrowingToEnd) {
            // Check the return of borrowings
            $this->assertDatabaseHas('borrowings', [
                'id' => $borrowingToEnd->id,
                'inventory_item_id' => $borrowingToEnd->inventory_item_id,
                'borrower_id' => $borrowingToEnd->borrower_id,
                'initial_lender_id' => $borrowingToEnd->initial_lender_id,
                'return_lender_id' => $lender->id,
                'start_date' => $borrowingToEnd->start_date->format('Y-m-d'),
                'expected_return_date' => $borrowingToEnd->expected_return_date->format('Y-m-d'),
                'return_date' => $currentDate->format('Y-m-d'),
                'guarantee' => $borrowingToEnd->guarantee,
                'notes_before' => $borrowingToEnd->notes_before,
                // 'notes_after' => $notes,
                'finished' => 1
            ]);

            // Check inventory items status updates
            $this->assertDatabaseHas('inventory_items', [
                'id' => $borrowingToEnd->inventory_item_id,
                'status_id' => InventoryItemStatus::IN_LCR_D4
            ]);
        }
    }

    public function testLostBorrowings()
    {
        // Create the necessary preliminary database records
        $borrowings = factory(Borrowing::class, 20)->create();
        $borrowingsToEnd = [$borrowings[8], $borrowings[1], $borrowings[2], $borrowings[19]];
        $lender = factory(User::class)->state('lender')->create();
        $currentDate = Carbon::now();

        $this->browse(function (Browser $browser) use ($borrowingsToEnd, $lender) {
            // Navigate to the end borrowing page
            $browser->loginAs($lender)
                ->visit(new HomePage())
                ->navigateTo(PagesFromHomeEnum::END_BORROWING)
                ->on(new EndBorrowingPage());

            // Select borrowings to end by clicking on them
            foreach ($borrowingsToEnd as $borrowingToEnd) {
                $browser->click('#borrowings-list-element-' . $borrowingToEnd->id);
            }

            // Confirm in the end borrowing modal
            $browser->click('@lostButton')
                ->whenAvailable('@endBorrowingModal', function($modal) {
                    $modal->press('@endBorrowingSubmitButton');
                });

            // Wait for the page reloading
            $browser->waitForReload();
            $browser->assertPathIs('/borrowings-history');
        });

        // Check the database for the changes
        foreach ($borrowingsToEnd as $borrowingToEnd) {
            // Check the return of borrowings
            $this->assertDatabaseHas('borrowings', [
                'id' => $borrowingToEnd->id,
                'inventory_item_id' => $borrowingToEnd->inventory_item_id,
                'borrower_id' => $borrowingToEnd->borrower_id,
                'initial_lender_id' => $borrowingToEnd->initial_lender_id,
                'return_lender_id' => $lender->id,
                'start_date' => $borrowingToEnd->start_date->format('Y-m-d'),
                'expected_return_date' => $borrowingToEnd->expected_return_date->format('Y-m-d'),
                'return_date' => $currentDate->format('Y-m-d'),
                'guarantee' => $borrowingToEnd->guarantee,
                'notes_before' => $borrowingToEnd->notes_before,
                // 'notes_after' => $notes,
                'finished' => 1
            ]);

            // Check inventory items status updates
            $this->assertDatabaseHas('inventory_items', [
                'id' => $borrowingToEnd->inventory_item_id,
                'status_id' => InventoryItemStatus::LOST
            ]);
        }
    }
}

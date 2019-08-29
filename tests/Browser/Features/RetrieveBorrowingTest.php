<?php

namespace Tests\Browser\Features;

use App\Borrowing;
use App\Genre;
use App\InventoryItem;
use App\InventoryItemStatus;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\EndBorrowingPage;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\PagesFromHomeEnum;
use Tests\DuskTestCase;

class RetrieveBorrowingTest extends DuskTestCase
{
    use WithFaker;

    private $borrowings;
    private $borrowingsToEnd;
    private $lender;

    protected function setUp(): void {
        Parent::setUp();
        $this->faker->seed(0);
        $borrowings = factory(Borrowing::class, 20)->create();
        $borrowingsToEnd = [$borrowings[8], $borrowings[1], $borrowings[2], $borrowings[19]];
        $lender = factory(User::class)->state('lender')->create();

        $this->borrowings = $borrowings;
        $this->borrowingsToEnd = $borrowingsToEnd;
        $this->lender = $lender;
    }

    protected function tearDown(): void {
        User::query()->delete();
        Genre::query()->delete();
        InventoryItem::query()->delete();
        Borrowing::query()->delete();
    }

    public function testReturnBorrowings()
    {
        $currentDate = Carbon::now();

        $this->browse(function (Browser $browser) {
            // Navigate to the end borrowing page
            $browser->loginAs($this->lender)
                ->visit(new HomePage)
                ->navigateTo(PagesFromHomeEnum::END_BORROWING)
                ->on(new EndBorrowingPage);

            // Select borrowings to end by clicking on them
            foreach ($this->borrowingsToEnd as $borrowingToEnd) {
                $browser->clickOnBorrowingButton($borrowingToEnd->id);
            }

            // Confirm in the end borrowing modal
            $browser->click('@returnButton')
                ->whenAvailable('@endBorrowingModal', function($modal) {
                    $modal->press('@endBorrowingSubmitButton');
                })
                ->waitForReload()
                ->assertPathIs('/borrowings-history');
        });

        // Check the database for the changes
        foreach ($this->borrowingsToEnd as $borrowingToEnd) {
            // Check the return of borrowings
            $this->assertDatabaseHas('borrowings', [
                'id' => $borrowingToEnd->id,
                'inventory_item_id' => $borrowingToEnd->inventory_item_id,
                'borrower_id' => $borrowingToEnd->borrower_id,
                'initial_lender_id' => $borrowingToEnd->initial_lender_id,
                'return_lender_id' => $this->lender->id,
                'start_date' => $borrowingToEnd->start_date->format('Y-m-d'),
                'expected_return_date' => $borrowingToEnd->expected_return_date->format('Y-m-d'),
                'return_date' => $currentDate->format('Y-m-d'),
                'guarantee' => $borrowingToEnd->guarantee,
                'notes_before' => $borrowingToEnd->notes_before,
                // 'notes_after' => $notes
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
        $currentDate = Carbon::now();

        $this->browse(function (Browser $browser) {
            // Navigate to the end borrowing page
            $browser->loginAs($this->lender)
                ->visit(new HomePage)
                ->navigateTo(PagesFromHomeEnum::END_BORROWING)
                ->on(new EndBorrowingPage);

            // Select borrowings to end by clicking on them
            foreach ($this->borrowingsToEnd as $borrowingToEnd) {
                $browser->clickOnBorrowingButton($borrowingToEnd->id);
            }

            // Confirm in the end borrowing modal
            $browser->click('@lostButton')
                ->whenAvailable('@endBorrowingModal', function($modal) {
                    $modal->press('@endBorrowingSubmitButton');
                })
                ->waitForReload()
                ->assertPathIs('/borrowings-history');
        });

        // Check the database for the changes
        foreach ($this->borrowingsToEnd as $borrowingToEnd) {
            // Check the return of borrowings
            $this->assertDatabaseHas('borrowings', [
                'id' => $borrowingToEnd->id,
                'inventory_item_id' => $borrowingToEnd->inventory_item_id,
                'borrower_id' => $borrowingToEnd->borrower_id,
                'initial_lender_id' => $borrowingToEnd->initial_lender_id,
                'return_lender_id' => $this->lender->id,
                'start_date' => $borrowingToEnd->start_date->format('Y-m-d'),
                'expected_return_date' => $borrowingToEnd->expected_return_date->format('Y-m-d'),
                'return_date' => $currentDate->format('Y-m-d'),
                'guarantee' => $borrowingToEnd->guarantee,
                'notes_before' => $borrowingToEnd->notes_before,
                // 'notes_after' => $notes
            ]);

            // Check inventory items status updates
            $this->assertDatabaseHas('inventory_items', [
                'id' => $borrowingToEnd->inventory_item_id,
                'status_id' => InventoryItemStatus::LOST
            ]);
        }
    }
}

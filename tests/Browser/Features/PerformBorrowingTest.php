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
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\NewBorrowingPage;
use Tests\Browser\Pages\PagesFromHomeEnum;
use Tests\DuskTestCase;

class PerformBorrowingTest extends DuskTestCase
{
    use WithFaker;

    private $lender;
    private $borrowerPassword;
    private $borrower;
    private $inventoryItems;

    protected function setUp(): void {
        Parent::setUp();
        $this->faker->seed(0);
        $lender = factory(User::class)->state('lender')->create();
        $borrowerPassword = $this->faker->unique()->password;
        $borrower = factory(User::class)->create([
            'password' => bcrypt($borrowerPassword)
        ]);
        $inventoryItems = factory(InventoryItem::class, 20)->create();

        $this->lender = $lender;
        $this->borrowerPassword = $borrowerPassword;
        $this->borrower = $borrower;
        $this->inventoryItems = $inventoryItems;
    }

    protected function tearDown(): void {
        User::query()->delete();
        Genre::query()->delete();
        InventoryItem::query()->delete();
        Borrowing::query()->delete();
    }

    public function testPerformBorrowing()
    {
        // Defining values to fill in the borrowing
        $fieldsValues = (object) [];
        $fieldsValues->borrowerEmail = $this->borrower->email;
        $fieldsValues->borrowerPassword = $this->borrowerPassword;
        $fieldsValues->inventoryItemsToBorrow = [
            $this->inventoryItems[5],
            $this->inventoryItems[7],
            $this->inventoryItems[8],
            $this->inventoryItems[16]];
        $fieldsValues->startDate = Carbon::now();
        $fieldsValues->expectedReturnDate = $fieldsValues->startDate->copy()->addDays(5);
        $fieldsValues->guarantee = 15;
        $fieldsValues->notes = $this->faker->text;

        $this->browse(function (Browser $browser) use ($fieldsValues) {
            // Navigate to the new borrowing page
            $browser->loginAs($this->lender)
                ->visit(new HomePage)
                ->navigateTo(PagesFromHomeEnum::NEW_BORROWING)
                ->on(new NewBorrowingPage)
                ->waitForPageLoaded();

            // Select inventory items to borrow by clicking on them
            foreach ($fieldsValues->inventoryItemsToBorrow as $inventoryItemToBorrow) {
                $browser->clickOnInventoryItemButton($inventoryItemToBorrow->id);
            }

            // Fill in the new borrowing modal
            $browser->click('@checkoutLink')
                ->waitFor('@newBorrowingModal')
                ->whenAvailable('@newBorrowingModal', function(Browser $modal) use ($fieldsValues) {
                    $modal->type('borrowerEmail', $fieldsValues->borrowerEmail)
                        ->type('borrowerPassword', $fieldsValues->borrowerPassword)
                        ->keys('#expectedReturnDate', $fieldsValues->expectedReturnDate->format('mdY'))
                        ->type('guarantee', $fieldsValues->guarantee)
                        ->type('notes', $fieldsValues->notes)
                        ->check('agreementCheck1')
                        ->check('agreementCheck2')
                        ->press('@newBorrowingSubmitButton');
                })
                ->waitForReload()
                ->assertPathIs('/');
        });

        // Check the database for the changes
        foreach ($fieldsValues->inventoryItemsToBorrow as $inventoryItemToBorrow) {
            // Check the creation of new borrowings
            $this->assertDatabaseHas('borrowings', [
                'inventory_item_id' => $inventoryItemToBorrow->id,
                'borrower_id' => $this->borrower->id,
                'initial_lender_id' => $this->lender->id,
                'return_lender_id' => null,
                'start_date' => $fieldsValues->startDate->format('Y-m-d'), // lol yeah this failed when I ran the test at midnight once
                'expected_return_date' => $fieldsValues->expectedReturnDate->format('Y-m-d'),
                'return_date' => null,
                'guarantee' => $fieldsValues->guarantee,
                'notes_before' => $fieldsValues->notes,
                'notes_after' => null
            ]);

            // Check inventory items status updates
            $this->assertDatabaseHas('inventory_items', [
                'id' => $inventoryItemToBorrow->id,
                'status_id' => InventoryItemStatus::BORROWED
            ]);
        }
    }
}

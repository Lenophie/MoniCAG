<?php

namespace Tests\Browser;

use App\InventoryItem;
use App\InventoryItemStatus;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\NewBorrowingPage;
use Tests\DuskTestCase;

class PerformANewBorrowingTest extends DuskTestCase
{
    use WithFaker;

    protected function setUp() {
        Parent::setUp();
        exec('php artisan migrate:refresh --seed --env=testing');
    }

    public function testPerformANewBorrowing()
    {
        // Create the necessary preliminary database records
        $lender = factory(User::class)->state('lender')->create();
        $borrowerPassword = $this->faker->unique()->password;
        $borrower = factory(User::class)->create([
            'password' => bcrypt($borrowerPassword)
        ]);
        $inventoryItems = factory(InventoryItem::class, 20)->create();

        // Defining values to fill in the borrowing
        $fieldsValues = (object) [];
        $fieldsValues->borrowerEmail = $borrower->email;
        $fieldsValues->borrowerPassword = $borrowerPassword;
        $fieldsValues->inventoryItemsToBorrow = [$inventoryItems[5], $inventoryItems[7], $inventoryItems[8], $inventoryItems[16]];
        $fieldsValues->startDate = Carbon::now();
        $fieldsValues->expectedReturnDate = $fieldsValues->startDate->copy()->addDays(5);
        $fieldsValues->guarantee = 15;
        $fieldsValues->notes = $this->faker->text;

        $this->browse(function (Browser $browser) use ($lender,$fieldsValues) {
            // Navigate to the new borrowing page
            $browser->loginAs($lender)
                ->visit(new HomePage())
                ->navigateTo('new-borrowing')
                ->on(new NewBorrowingPage());

            // Select inventory items to borrow by clicking on them
            foreach ($fieldsValues->inventoryItemsToBorrow as $inventoryItemToBorrow) {
                $browser->click('#inventory-item-button-' . $inventoryItemToBorrow->id);
            }

            // Fill in the new borrowing modal
            $browser->click('@checkoutLink')
                ->whenAvailable('@newBorrowingModal', function($modal) use ($fieldsValues) {
                    $modal->type('borrowerEmail', $fieldsValues->borrowerEmail)
                        ->type('borrowerPassword', $fieldsValues->borrowerPassword)
                        ->type('expectedReturnDate', $fieldsValues->expectedReturnDate->format('d/m/Y'))
                        ->type('guarantee', $fieldsValues->guarantee)
                        ->type('notes', $fieldsValues->notes)
                        ->check('agreementCheck1')
                        ->check('agreementCheck2')
                        ->press('@newBorrowingSubmitButton');
                });

            // Wait for the page reloading
            $browser->waitForReload();
            $browser->assertPathIs('/borrowings-history');
        });

        // Check the database for the changes
        foreach ($fieldsValues->inventoryItemsToBorrow as $inventoryItemToBorrow) {
            // Check the creation of new borrowings
            $this->assertDatabaseHas('borrowings', [
                'inventory_item_id' => $inventoryItemToBorrow->id,
                'borrower_id' => $borrower->id,
                'initial_lender_id' => $lender->id,
                'return_lender_id' => null,
                'start_date' => $fieldsValues->startDate->format('Y-m-d'),
                'expected_return_date' => $fieldsValues->expectedReturnDate->format('Y-m-d'),
                'return_date' => null,
                'guarantee' => $fieldsValues->guarantee,
                'notes_before' => $fieldsValues->notes,
                'notes_after' => null,
                'finished' => 0
            ]);

            // Check inventory items status updates
            $this->assertDatabaseHas('inventory_items', [
                'id' => $inventoryItemToBorrow->id,
                'status_id' => InventoryItemStatus::BORROWED
            ]);
        }
    }
}

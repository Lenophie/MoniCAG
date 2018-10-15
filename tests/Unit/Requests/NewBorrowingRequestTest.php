<?php

use App\InventoryItem;
use App\InventoryItemStatus;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewBorrowingRequestTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    private $lender;

    protected function setUp()
    {
        Parent::setUp();
        $lender = factory(User::class)->state('lender')->create();
        $this->actingAs($lender);
        $this->lender = $lender;
    }

    /**
     * Tests new borrowing request.
     *
     * @return void
     */
    public function testNewBorrowingRequest()
    {
        // Fields values setup
        $inventoryItems = factory(InventoryItem::class, 5)->create();
        $borrowerPassword = $this->faker->unique()->password;
        $borrower = factory(User::class)->create([
            'password' => bcrypt($borrowerPassword)
        ]);
        $startDate = Carbon::now();
        $expectedReturnDate = $startDate->copy()->addDays(5);
        $guarantee = 15;
        $notes = $this->faker->text;

        // Create borrowing
        $response = $this->json('POST', '/new-borrowing', [
            'borrowedItems' => [
                $inventoryItems[0]->id,
                $inventoryItems[2]->id
            ],
            'borrowerEmail' => $borrower->email,
            'borrowerPassword' => $borrowerPassword,
            'expectedReturnDate' => $expectedReturnDate->format('d/m/Y'),
            'guarantee' => $guarantee,
            'agreementCheck1' => 'on',
            'agreementCheck2' => 'on',
            'notes' => $notes
        ]);

        // Check response
        $response->assertStatus(200);

        // Check borrowings creation in database
        $this->assertDatabaseHas('borrowings', [
            'inventory_item_id' => $inventoryItems[0]->id,
            'borrower_id' => $borrower->id,
            'initial_lender_id' => $this->lender->id,
            'return_lender_id' => null,
            'start_date' => $startDate->format('Y-m-d'),
            'expected_return_date' => $expectedReturnDate->format('Y-m-d'),
            'return_date' => null,
            'guarantee' => $guarantee,
            'notes_before' => $notes,
            'notes_after' => null,
            'finished' => 0
        ]);
        $this->assertDatabaseHas('borrowings', [
            'inventory_item_id' => $inventoryItems[2]->id,
            'borrower_id' => $borrower->id,
            'initial_lender_id' => $this->lender->id,
            'return_lender_id' => null,
            'start_date' => $startDate->format('Y-m-d'),
            'expected_return_date' => $expectedReturnDate->format('Y-m-d'),
            'return_date' => null,
            'guarantee' => $guarantee,
            'notes_before' => $notes,
            'notes_after' => null,
            'finished' => 0
        ]);

        // Check inventory items status updates
        $this->assertDatabaseHas('inventory_items', [
           'id' => $inventoryItems[0]->id,
           'status_id' => InventoryItemStatus::BORROWED
        ]);
        $this->assertDatabaseHas('inventory_items', [
            'id' => $inventoryItems[2]->id,
            'status_id' => InventoryItemStatus::BORROWED
        ]);

        // Check other inventory items unaffected
        $this->assertDatabaseMissing('inventory_items', [
            'id' => $inventoryItems[1]->id,
            'status_id' => InventoryItemStatus::BORROWED
        ]);
        $this->assertDatabaseMissing('inventory_items', [
            'id' => $inventoryItems[3]->id,
            'status_id' => InventoryItemStatus::BORROWED
        ]);
        $this->assertDatabaseMissing('inventory_items', [
            'id' => $inventoryItems[4]->id,
            'status_id' => InventoryItemStatus::BORROWED
        ]);
    }
}

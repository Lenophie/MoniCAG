<?php

use App\Borrowing;
use App\InventoryItemStatus;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EndBorrowingRequestTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    public $lender;

    protected function setUp()
    {
        Parent::setUp();
        $lender = factory(User::class)->state('lender')->create();
        $this->actingAs($lender);
        $this->lender = $lender;
    }

    /**
     * Tests return borrowings request.
     *
     * @return void
     */
    public function testReturnBorrowingsRequest()
    {
        // Fields values setup
        $borrowings = factory(Borrowing::class, 5)->create();
        $returnDate = Carbon::now();
        // $notes = $this->faker->text;

        // Return borrowings
        $response = $this->json('PATCH', '/end-borrowing', [
            'selectedBorrowings' => [
                $borrowings[0]->id,
                $borrowings[2]->id
            ],
            'newInventoryItemsStatus' => InventoryItemStatus::IN_LCR_D4
        ]);

        // Check response
        $response->assertStatus(200);

        // Check borrowings creation in database
        $this->assertDatabaseHas('borrowings', [
            'id' => $borrowings[0]->id,
            'inventory_item_id' => $borrowings[0]->inventory_item_id,
            'borrower_id' => $borrowings[0]->borrower_id,
            'initial_lender_id' => $borrowings[0]->initial_lender_id,
            'return_lender_id' => $this->lender->id,
            'start_date' => $borrowings[0]->start_date->format('Y-m-d'),
            'expected_return_date' => $borrowings[0]->expected_return_date->format('Y-m-d'),
            'return_date' => $returnDate->format('Y-m-d'),
            'guarantee' => $borrowings[0]->guarantee,
            'notes_before' => $borrowings[0]->notes_before,
            // 'notes_after' => $notes,
            'finished' => 1
        ]);

        $this->assertDatabaseHas('borrowings', [
            'id' => $borrowings[2]->id,
            'inventory_item_id' => $borrowings[2]->inventory_item_id,
            'borrower_id' => $borrowings[2]->borrower_id,
            'initial_lender_id' => $borrowings[2]->initial_lender_id,
            'return_lender_id' => $this->lender->id,
            'start_date' => $borrowings[2]->start_date->format('Y-m-d'),
            'expected_return_date' => $borrowings[2]->expected_return_date->format('Y-m-d'),
            'return_date' => $returnDate->format('Y-m-d'),
            'guarantee' => $borrowings[2]->guarantee,
            'notes_before' => $borrowings[2]->notes_before,
            // 'notes_after' => $notes,
            'finished' => 1
        ]);

        // Check inventory items status updates
        $this->assertDatabaseHas('inventory_items', [
            'id' => $borrowings[0]->inventory_item_id,
            'status_id' => InventoryItemStatus::IN_LCR_D4
        ]);
        $this->assertDatabaseHas('inventory_items', [
            'id' => $borrowings[2]->inventory_item_id,
            'status_id' => InventoryItemStatus::IN_LCR_D4
        ]);

        // Check other borrowed inventory items unaffected
        $this->assertDatabaseHas('inventory_items', [
            'id' => $borrowings[1]->inventory_item_id,
            'status_id' => InventoryItemStatus::BORROWED
        ]);
        $this->assertDatabaseHas('inventory_items', [
            'id' => $borrowings[3]->inventory_item_id,
            'status_id' => InventoryItemStatus::BORROWED
        ]);
        $this->assertDatabaseHas('inventory_items', [
            'id' => $borrowings[4]->inventory_item_id,
            'status_id' => InventoryItemStatus::BORROWED
        ]);

        // Check other borrowings unaffected
        $this->assertDatabaseHas('borrowings', [
            'id' => $borrowings[1]->id,
            'inventory_item_id' => $borrowings[1]->inventory_item_id,
            'borrower_id' => $borrowings[1]->borrower_id,
            'initial_lender_id' => $borrowings[1]->initial_lender_id,
            'return_lender_id' => null,
            'start_date' => $borrowings[1]->start_date->format('Y-m-d'),
            'expected_return_date' => $borrowings[1]->expected_return_date->format('Y-m-d'),
            'return_date' => null,
            'guarantee' => $borrowings[1]->guarantee,
            'notes_before' => $borrowings[1]->notes_before,
            'notes_after' => null,
            'finished' => 0
        ]);
        $this->assertDatabaseHas('borrowings', [
            'id' => $borrowings[3]->id,
            'inventory_item_id' => $borrowings[3]->inventory_item_id,
            'borrower_id' => $borrowings[3]->borrower_id,
            'initial_lender_id' => $borrowings[3]->initial_lender_id,
            'return_lender_id' => null,
            'start_date' => $borrowings[3]->start_date->format('Y-m-d'),
            'expected_return_date' => $borrowings[3]->expected_return_date->format('Y-m-d'),
            'return_date' => null,
            'guarantee' => $borrowings[3]->guarantee,
            'notes_before' => $borrowings[3]->notes_before,
            'notes_after' => null,
            'finished' => 0
        ]);
        $this->assertDatabaseHas('borrowings', [
            'id' => $borrowings[4]->id,
            'inventory_item_id' => $borrowings[4]->inventory_item_id,
            'borrower_id' => $borrowings[4]->borrower_id,
            'initial_lender_id' => $borrowings[4]->initial_lender_id,
            'return_lender_id' => null,
            'start_date' => $borrowings[4]->start_date->format('Y-m-d'),
            'expected_return_date' => $borrowings[4]->expected_return_date->format('Y-m-d'),
            'return_date' => null,
            'guarantee' => $borrowings[4]->guarantee,
            'notes_before' => $borrowings[4]->notes_before,
            'notes_after' => null,
            'finished' => 0
        ]);
    }

    /**
     * Tests lost borrowings request.
     *
     * @return void
     */
    public function testLostBorrowingsRequest()
    {
        // Fields values setup
        $borrowings = factory(Borrowing::class, 5)->create();
        $returnDate = Carbon::now();
        // $notes = $this->faker->text;

        // Return borrowings
        $response = $this->json('PATCH', '/end-borrowing', [
            'selectedBorrowings' => [
                $borrowings[0]->id,
                $borrowings[2]->id
            ],
            'newInventoryItemsStatus' => InventoryItemStatus::LOST
        ]);

        // Check response
        $response->assertStatus(200);

        // Check borrowings creation in database
        $this->assertDatabaseHas('borrowings', [
            'id' => $borrowings[0]->id,
            'inventory_item_id' => $borrowings[0]->inventory_item_id,
            'borrower_id' => $borrowings[0]->borrower_id,
            'initial_lender_id' => $borrowings[0]->initial_lender_id,
            'return_lender_id' => $this->lender->id,
            'start_date' => $borrowings[0]->start_date->format('Y-m-d'),
            'expected_return_date' => $borrowings[0]->expected_return_date->format('Y-m-d'),
            'return_date' => $returnDate->format('Y-m-d'),
            'guarantee' => $borrowings[0]->guarantee,
            'notes_before' => $borrowings[0]->notes_before,
            // 'notes_after' => $notes,
            'finished' => 1
        ]);

        $this->assertDatabaseHas('borrowings', [
            'id' => $borrowings[2]->id,
            'inventory_item_id' => $borrowings[2]->inventory_item_id,
            'borrower_id' => $borrowings[2]->borrower_id,
            'initial_lender_id' => $borrowings[2]->initial_lender_id,
            'return_lender_id' => $this->lender->id,
            'start_date' => $borrowings[2]->start_date->format('Y-m-d'),
            'expected_return_date' => $borrowings[2]->expected_return_date->format('Y-m-d'),
            'return_date' => $returnDate->format('Y-m-d'),
            'guarantee' => $borrowings[2]->guarantee,
            'notes_before' => $borrowings[2]->notes_before,
            // 'notes_after' => $notes,
            'finished' => 1
        ]);

        // Check inventory items status updates
        $this->assertDatabaseHas('inventory_items', [
            'id' => $borrowings[0]->inventory_item_id,
            'status_id' => InventoryItemStatus::LOST
        ]);
        $this->assertDatabaseHas('inventory_items', [
            'id' => $borrowings[2]->inventory_item_id,
            'status_id' => InventoryItemStatus::LOST
        ]);

        // Check other borrowed inventory items unaffected
        $this->assertDatabaseHas('inventory_items', [
            'id' => $borrowings[1]->inventory_item_id,
            'status_id' => InventoryItemStatus::BORROWED
        ]);
        $this->assertDatabaseHas('inventory_items', [
            'id' => $borrowings[3]->inventory_item_id,
            'status_id' => InventoryItemStatus::BORROWED
        ]);
        $this->assertDatabaseHas('inventory_items', [
            'id' => $borrowings[4]->inventory_item_id,
            'status_id' => InventoryItemStatus::BORROWED
        ]);

        // Check other borrowings unaffected
        $this->assertDatabaseHas('borrowings', [
            'id' => $borrowings[1]->id,
            'inventory_item_id' => $borrowings[1]->inventory_item_id,
            'borrower_id' => $borrowings[1]->borrower_id,
            'initial_lender_id' => $borrowings[1]->initial_lender_id,
            'return_lender_id' => null,
            'start_date' => $borrowings[1]->start_date->format('Y-m-d'),
            'expected_return_date' => $borrowings[1]->expected_return_date->format('Y-m-d'),
            'return_date' => null,
            'guarantee' => $borrowings[1]->guarantee,
            'notes_before' => $borrowings[1]->notes_before,
            'notes_after' => null,
            'finished' => 0
        ]);
        $this->assertDatabaseHas('borrowings', [
            'id' => $borrowings[3]->id,
            'inventory_item_id' => $borrowings[3]->inventory_item_id,
            'borrower_id' => $borrowings[3]->borrower_id,
            'initial_lender_id' => $borrowings[3]->initial_lender_id,
            'return_lender_id' => null,
            'start_date' => $borrowings[3]->start_date->format('Y-m-d'),
            'expected_return_date' => $borrowings[3]->expected_return_date->format('Y-m-d'),
            'return_date' => null,
            'guarantee' => $borrowings[3]->guarantee,
            'notes_before' => $borrowings[3]->notes_before,
            'notes_after' => null,
            'finished' => 0
        ]);
        $this->assertDatabaseHas('borrowings', [
            'id' => $borrowings[4]->id,
            'inventory_item_id' => $borrowings[4]->inventory_item_id,
            'borrower_id' => $borrowings[4]->borrower_id,
            'initial_lender_id' => $borrowings[4]->initial_lender_id,
            'return_lender_id' => null,
            'start_date' => $borrowings[4]->start_date->format('Y-m-d'),
            'expected_return_date' => $borrowings[4]->expected_return_date->format('Y-m-d'),
            'return_date' => null,
            'guarantee' => $borrowings[4]->guarantee,
            'notes_before' => $borrowings[4]->notes_before,
            'notes_after' => null,
            'finished' => 0
        ]);
    }
}

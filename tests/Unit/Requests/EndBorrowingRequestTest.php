<?php

use App\Borrowing;
use App\InventoryItemStatus;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class EndBorrowingRequestTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    private $lender;

    protected function setUp(): void
    {
        Parent::setUp();
        $this->faker->seed(0);
        $lender = factory(User::class)->state('lender')->create();
        $this->actingAs($lender, 'api');
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
        $response = $this->json('PATCH', route('borrowings.return'), [
            'selectedBorrowings' => [
                $borrowings[0]->id,
                $borrowings[2]->id
            ],
            'newInventoryItemsStatus' => InventoryItemStatus::IN_LCR_D4
        ]);

        // Check response
        $response->assertStatus(Response::HTTP_OK);

        foreach([0, 2] as $i) {
            // Check inventory items status updates
            $this->assertDatabaseHas('inventory_items', [
                'id' => $borrowings[$i]->inventory_item_id,
                'status_id' => InventoryItemStatus::IN_LCR_D4
            ]);

            // Check borrowings creation in database
            $this->assertDatabaseHas('borrowings', [
                'id' => $borrowings[$i]->id,
                'inventory_item_id' => $borrowings[$i]->inventory_item_id,
                'borrower_id' => $borrowings[$i]->borrower_id,
                'initial_lender_id' => $borrowings[$i]->initial_lender_id,
                'return_lender_id' => $this->lender->id,
                'start_date' => $borrowings[$i]->start_date->format('Y-m-d'),
                'expected_return_date' => $borrowings[$i]->expected_return_date->format('Y-m-d'),
                'return_date' => $returnDate->format('Y-m-d'),
                'guarantee' => $borrowings[$i]->guarantee,
                'notes_before' => $borrowings[$i]->notes_before,
                // 'notes_after' => $notes,
            ]);
        }

        foreach([1, 3, 4] as $i) {
            // Check other borrowed inventory items unaffected
            $this->assertDatabaseHas('inventory_items', [
                'id' => $borrowings[$i]->inventory_item_id,
                'status_id' => InventoryItemStatus::BORROWED
            ]);

            // Check other borrowings unaffected
            $this->assertDatabaseHas('borrowings', [
                'id' => $borrowings[$i]->id,
                'inventory_item_id' => $borrowings[$i]->inventory_item_id,
                'borrower_id' => $borrowings[$i]->borrower_id,
                'initial_lender_id' => $borrowings[$i]->initial_lender_id,
                'return_lender_id' => null,
                'start_date' => $borrowings[$i]->start_date->format('Y-m-d'),
                'expected_return_date' => $borrowings[$i]->expected_return_date->format('Y-m-d'),
                'return_date' => null,
                'guarantee' => $borrowings[$i]->guarantee,
                'notes_before' => $borrowings[$i]->notes_before,
                'notes_after' => null
            ]);
        }
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
        $response = $this->json('PATCH', route('borrowings.return'), [
            'selectedBorrowings' => [
                $borrowings[0]->id,
                $borrowings[2]->id
            ],
            'newInventoryItemsStatus' => InventoryItemStatus::LOST
        ]);

        // Check response
        $response->assertStatus(Response::HTTP_OK);

        foreach([0, 2] as $i) {
            // Check inventory items status updates
            $this->assertDatabaseHas('inventory_items', [
                'id' => $borrowings[$i]->inventory_item_id,
                'status_id' => InventoryItemStatus::LOST
            ]);

            // Check borrowings creation in database
            $this->assertDatabaseHas('borrowings', [
                'id' => $borrowings[$i]->id,
                'inventory_item_id' => $borrowings[$i]->inventory_item_id,
                'borrower_id' => $borrowings[$i]->borrower_id,
                'initial_lender_id' => $borrowings[$i]->initial_lender_id,
                'return_lender_id' => $this->lender->id,
                'start_date' => $borrowings[$i]->start_date->format('Y-m-d'),
                'expected_return_date' => $borrowings[$i]->expected_return_date->format('Y-m-d'),
                'return_date' => $returnDate->format('Y-m-d'),
                'guarantee' => $borrowings[$i]->guarantee,
                'notes_before' => $borrowings[$i]->notes_before,
                // 'notes_after' => $notes
            ]);
        }

        foreach([1, 3, 4] as $i) {
            // Check other borrowed inventory items unaffected
            $this->assertDatabaseHas('inventory_items', [
                'id' => $borrowings[$i]->inventory_item_id,
                'status_id' => InventoryItemStatus::BORROWED
            ]);

            // Check other borrowings unaffected
            $this->assertDatabaseHas('borrowings', [
                'id' => $borrowings[$i]->id,
                'inventory_item_id' => $borrowings[$i]->inventory_item_id,
                'borrower_id' => $borrowings[$i]->borrower_id,
                'initial_lender_id' => $borrowings[$i]->initial_lender_id,
                'return_lender_id' => null,
                'start_date' => $borrowings[$i]->start_date->format('Y-m-d'),
                'expected_return_date' => $borrowings[$i]->expected_return_date->format('Y-m-d'),
                'return_date' => null,
                'guarantee' => $borrowings[$i]->guarantee,
                'notes_before' => $borrowings[$i]->notes_before,
                'notes_after' => null
            ]);
        }
    }
}

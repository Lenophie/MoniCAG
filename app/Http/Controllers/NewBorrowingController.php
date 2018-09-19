<?php

namespace App\Http\Controllers;

use App\Borrowing;
use App\Http\Requests\NewBorrowingRequest;
use App\InventoryItem;
use App\InventoryItemStatus;
use Carbon\Carbon;

class newBorrowingController extends Controller
{
    public function index()
    {
        $inventoryItems = InventoryItem::allJoined();
        return view('new-borrowing', compact('inventoryItems'));
    }

    public function store(NewBorrowingRequest $request)
    {
        foreach (request('borrowedItems') as $borrowedItem) {
            $startDate = Carbon::createFromFormat('d/m/Y', request('startDate'));
            $expectedReturnDate = Carbon::createFromFormat('d/m/Y', request('expectedReturnDate'));
            Borrowing::create([
                'inventory_item_id' => $borrowedItem,
                'borrower_id' => 1, // to change when authentication will be setup
                'initial_lender_id' => 1,  // to change when authentication will be setup
                'guarantee' => request('guarantee'),
                'finished' => false,
                'start_date' => $startDate,
                'expected_return_date' => $expectedReturnDate,
                'notes_before' => request('notes')
            ]);
            InventoryItem::where('id', $borrowedItem)->update(['status_id' => InventoryItemStatus::EMPRUNTE]);
        }
    }
}

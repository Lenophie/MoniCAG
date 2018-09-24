<?php

namespace App\Http\Controllers;

use App\Borrowing;
use App\Http\Requests\EndBorrowingRequest;
use App\InventoryItem;
use App\InventoryItemStatus;
use Carbon\Carbon;

class EndBorrowingController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        $borrowings = Borrowing::current();
        return view('end-borrowing', compact('borrowings'));
    }

    public function updateReturned(EndBorrowingRequest $request)
    {
        foreach (request('selectedBorrowings') as $selectedBorrowing) {
            Borrowing::where('id', $selectedBorrowing)
                ->update([
                    'finished' => true,
                    'return_lender_id' => 1, // to change when authentication will be setup
                    'return_date' => Carbon::now()
                ]);
            InventoryItem::with('borrowing')
                ->whereHas('borrowing', function($q) use($selectedBorrowing) {
                    $q->where('id', $selectedBorrowing);})
                ->update(['status_id' => InventoryItemStatus::IN_LCR_D4]);
        }
    }

    public function updateLost(EndBorrowingRequest $request)
    {
        foreach (request('selectedBorrowings') as $selectedBorrowing) {
            Borrowing::where('id', $selectedBorrowing)
                ->update([
                    'finished' => true,
                    'return_lender_id' => 1, // to change when authentication will be setup
                    'return_date' => Carbon::now()
                ]);
            InventoryItem::with('borrowing')
                ->whereHas('borrowing', function($q) use($selectedBorrowing) {
                    $q->where('id', $selectedBorrowing);})
                ->update(['status_id' => InventoryItemStatus::LOST]);
        }
    }
}

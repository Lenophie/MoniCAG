<?php

namespace App\Http\Controllers;

use App\Borrowing;
use App\Http\Requests\EndBorrowingRequest;
use App\InventoryItem;
use App\InventoryItemStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EndBorrowingController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('lender');
    }

    public function index()
    {
        $borrowings = Borrowing::current();
        $inventoryItemStatuses = (object) [
            'RETURNED' => InventoryItemStatus::IN_LCR_D4,
            'LOST' => InventoryItemStatus::LOST
        ];
        return view('end-borrowing', compact('borrowings', 'inventoryItemStatuses'));
    }

    public function updateReturned(EndBorrowingRequest $request)
    {
        foreach (request('selectedBorrowings') as $selectedBorrowing) {
            Borrowing::where('id', $selectedBorrowing)
                ->update([
                    'finished' => true,
                    'return_lender_id' => Auth::user()->id,
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
                    'return_lender_id' => Auth::user()->id,
                    'return_date' => Carbon::now()
                ]);
            InventoryItem::with('borrowing')
                ->whereHas('borrowing', function($q) use($selectedBorrowing) {
                    $q->where('id', $selectedBorrowing);})
                ->update(['status_id' => InventoryItemStatus::LOST]);
        }
    }
}

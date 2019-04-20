<?php

namespace App\Http\Controllers\Web;

use App\Borrowing;
use App\Http\Controllers\Controller;
use App\Http\Requests\EndBorrowingRequest;
use App\InventoryItem;
use App\InventoryItemStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function patch(EndBorrowingRequest $request)
    {
        $newInventoryItemsStatus = (int) request('newInventoryItemsStatus');
        if ($newInventoryItemsStatus === InventoryItemStatus::IN_LCR_D4) {
            foreach (request('selectedBorrowings') as $selectedBorrowing) {
                DB::transaction(function() use ($selectedBorrowing) {
                    Borrowing::where('id', $selectedBorrowing)
                        ->update([
                            'finished' => true,
                            'return_lender_id' => Auth::user()->id,
                            'return_date' => Carbon::now()
                        ]);
                    InventoryItem::with('borrowing')
                        ->whereHas('borrowing', function ($q) use ($selectedBorrowing) {
                            $q->where('id', $selectedBorrowing);
                        })
                        ->update(['status_id' => InventoryItemStatus::IN_LCR_D4]);
                });
            }
        } else if ($newInventoryItemsStatus === InventoryItemStatus::LOST) {
            foreach (request('selectedBorrowings') as $selectedBorrowing) {
                DB::transaction(function() use ($selectedBorrowing) {
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
                });
            }
        } else abort(422);
    }
}

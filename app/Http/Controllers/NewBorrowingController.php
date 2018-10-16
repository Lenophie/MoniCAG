<?php

namespace App\Http\Controllers;

use App\Borrowing;
use App\Http\Requests\NewBorrowingRequest;
use App\InventoryItem;
use App\InventoryItemStatus;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class newBorrowingController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('lender');
    }

    public function index()
    {
        $inventoryItems = InventoryItem::allJoined();
        return view('new-borrowing', compact('inventoryItems'));
    }

    public function store(NewBorrowingRequest $request)
    {
        foreach (request('borrowedItems') as $borrowedItem) {
            $expectedReturnDate = Carbon::createFromFormat('d/m/Y', request('expectedReturnDate'));
            $borrowerId = User::where('email', request('borrowerEmail'))->select('id')->first()->id;
            Borrowing::create([
                'inventory_item_id' => $borrowedItem,
                'borrower_id' => $borrowerId,
                'initial_lender_id' => Auth::user()->id,
                'guarantee' => request('guarantee'),
                'finished' => false,
                'start_date' => Carbon::now(),
                'expected_return_date' => $expectedReturnDate,
                'notes_before' => htmlspecialchars(request('notes'))
            ]);
            InventoryItem::where('id', $borrowedItem)->update(['status_id' => InventoryItemStatus::BORROWED]);
        }
    }
}

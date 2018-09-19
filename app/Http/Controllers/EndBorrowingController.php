<?php

namespace App\Http\Controllers;

use App\Borrowing;
use App\Http\Requests\EndBorrowingRequest;
use App\InventoryItem;

class EndBorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::allCurrent();
        return view('end-borrowing', compact('borrowings'));
    }

    public function updateReturned(EndBorrowingRequest $request)
    {
        foreach (request('selectedBorrowings') as $selectedBorrowing) {
            Borrowing::where('id', $selectedBorrowing)->update(['finished' => true]);
            InventoryItem::with('borrowing')
                ->whereHas('borrowing', function($q) use($selectedBorrowing) {
                    $q->where('id', $selectedBorrowing);})
                ->update(['status_id' => 1]);
        }
    }

    public function updateLost(EndBorrowingRequest $requestEn)
    {
        foreach (request('selectedBorrowings') as $selectedBorrowing) {
            Borrowing::where('id', $selectedBorrowing)->update(['finished' => true]);
            InventoryItem::with('borrowing')
                ->whereHas('borrowing', function($q) use($selectedBorrowing) {
                    $q->where('id', $selectedBorrowing);})
                ->update(['status_id' => 4]);
        }
    }

}

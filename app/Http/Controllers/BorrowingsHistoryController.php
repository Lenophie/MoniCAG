<?php

namespace App\Http\Controllers;

use App\Borrowing;

class BorrowingsHistoryController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::history();
        return view('borrowings-history', compact('borrowings'));
    }
}

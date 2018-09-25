<?php

namespace App\Http\Controllers;

use App\Borrowing;

class BorrowingsHistoryController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('lender');
    }

    public function index()
    {
        $borrowings = Borrowing::history();
        return view('borrowings-history', compact('borrowings'));
    }
}

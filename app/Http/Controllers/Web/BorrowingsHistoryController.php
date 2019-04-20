<?php

namespace App\Http\Controllers\Web;

use App\Borrowing;
use App\Http\Controllers\Controller;

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

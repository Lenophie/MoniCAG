<?php

namespace App\Http\Controllers;

use App\Borrowing;

class EndBorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::allCurrent();
        return view('end-borrowing', compact('borrowings'));
    }
}

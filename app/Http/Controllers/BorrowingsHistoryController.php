<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BorrowingsHistoryController extends Controller
{
    public function index()
    {
        return view('borrowings-history');
    }
}

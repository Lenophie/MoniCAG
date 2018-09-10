<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class newBorrowingController extends Controller
{
    public function index()
    {
        return view('new-borrowing');
    }
}

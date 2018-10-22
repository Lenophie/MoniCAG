<?php

namespace App\Http\Controllers;


use App\Borrowing;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        $userBorrowings = Borrowing::userCurrentHistory(Auth::user()->id);
        return view('account', compact('userBorrowings'));
    }
}

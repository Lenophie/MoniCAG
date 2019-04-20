<?php

namespace App\Http\Controllers\Web;


use App\Borrowing;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteAccountRequest;
use App\User;
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

    public function delete(DeleteAccountRequest $request)
    {
        User::destroy(Auth::user()->id);
    }
}

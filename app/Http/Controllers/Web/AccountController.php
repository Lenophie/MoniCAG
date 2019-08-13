<?php

namespace App\Http\Controllers\Web;


use App\Borrowing;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteAccountRequest;
use App\Http\Resources\API\BorrowingResource;
use App\User;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $userCurrentBorrowings = Borrowing::with('inventoryItem')
            ->where('borrower_id', $user->id)
            ->whereNull('return_date')
            ->get();

        $userBorrowings = BorrowingResource::collection($userCurrentBorrowings)->jsonSerialize();

        return view('account', compact('userBorrowings', 'user'));
    }

    public function delete(DeleteAccountRequest $request)
    {
        User::destroy(Auth::user()->id);
    }
}

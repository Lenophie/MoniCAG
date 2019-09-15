<?php

namespace App\Http\Controllers\Web;


use App\Borrowing;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\BorrowingResource;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $user = Auth::user();
        $userCurrentBorrowings = Borrowing::with('inventoryItem')
            ->where('borrower_id', $user->id)
            ->whereNull('return_date')
            ->get();
        $userPastBorrowings = Borrowing::with('inventoryItem')
            ->where('borrower_id', $user->id)
            ->whereNotNull('return_date')
            ->get();

        $userBorrowings = BorrowingResource::collection($userCurrentBorrowings)->jsonSerialize();
        $userPastBorrowings = BorrowingResource::collection($userPastBorrowings)->jsonSerialize();

        $compactData = [
            'routes' => [
                'account' => [
                    'deletion' => route('users.destroy', $user->id)
                ]
            ]
        ];

        return view('account', compact('userBorrowings', 'userPastBorrowings', 'user', 'compactData'));
    }
}

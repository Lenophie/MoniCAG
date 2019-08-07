<?php

namespace App\Http\Controllers\Web;

use App\Borrowing;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class BorrowingsHistoryController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        abort_unless(Gate::allows('viewAny', Borrowing::class), Response::HTTP_FORBIDDEN);
        $borrowings = Borrowing::history();
        return view('borrowings-history', compact('borrowings'));
    }
}

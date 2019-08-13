<?php

namespace App\Http\Controllers\Web;

use App\Borrowing;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\BorrowingResource;
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
        $eagerLoadedBorrowings = Borrowing::with('inventoryItem', 'borrower', 'initialLender', 'returnLender')
            ->orderByDate()->get();
        $borrowings = BorrowingResource::collection($eagerLoadedBorrowings)->jsonSerialize();

        return view('borrowings-history', compact('borrowings'));
    }
}

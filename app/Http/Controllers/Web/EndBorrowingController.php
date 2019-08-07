<?php

namespace App\Http\Controllers\Web;

use App\Borrowing;
use App\Http\Controllers\Controller;
use App\InventoryItemStatus;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class EndBorrowingController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        abort_unless(Gate::allows('return', Borrowing::class), Response::HTTP_FORBIDDEN);

        $borrowings = Borrowing::current();
        $inventoryItemStatuses = (object) [
            'RETURNED' => InventoryItemStatus::IN_LCR_D4,
            'LOST' => InventoryItemStatus::LOST
        ];
        return view('end-borrowing', compact('borrowings', 'inventoryItemStatuses'));
    }
}

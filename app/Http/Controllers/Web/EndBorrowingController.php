<?php

namespace App\Http\Controllers\Web;

use App\Borrowing;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\BorrowingResource;
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

        $eagerLoadedBorrowings = Borrowing::with('inventoryItem', 'borrower', 'initialLender')
            ->where('return_date', null)->orderByDate()->get();
        $borrowings = BorrowingResource::collection($eagerLoadedBorrowings);

        $compactData = [
            'resources' => [
                'borrowings' => $borrowings,
                'newInventoryItemsStatuses' => [
                    'return' => InventoryItemStatus::IN_LCR_D4,
                    'lost' => InventoryItemStatus::LOST
                ]
            ],
            'routes' => [
                'borrowings' => route('borrowings.return')
            ]
        ];
        return view('end-borrowing', compact('compactData'));
    }
}

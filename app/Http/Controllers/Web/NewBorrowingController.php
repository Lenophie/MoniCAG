<?php

namespace App\Http\Controllers\Web;

use App\Borrowing;
use App\Http\Controllers\Controller;
use App\Http\Resources\Views\DetailedInventoryItemResource;
use App\InventoryItem;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class newBorrowingController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        abort_unless(Gate::allows('create', Borrowing::class), Response::HTTP_FORBIDDEN);

        $inventoryItems = DetailedInventoryItemResource::collection(InventoryItem::all())->collection;

        $compactData = [
            'resources' => [
                'inventoryItems' => $inventoryItems
            ],
            'routes' => [
                'borrowings' => route('borrowings.index')
            ]
        ];

        return view('new-borrowing', compact('compactData'));
    }
}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\InventoryItem;

class newBorrowingController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('lender');
    }

    public function index()
    {
        $inventoryItems = InventoryItem::allJoined();
        return view('new-borrowing', compact('inventoryItems'));
    }
}

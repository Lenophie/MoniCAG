<?php

namespace App\Http\Controllers;

use App\InventoryItem;

class newBorrowingController extends Controller
{
    public function index()
    {
        $inventoryItems = InventoryItem::joinedAll();
        return view('new-borrowing', compact('inventoryItems'));
    }

    public function store()
    {

    }
}

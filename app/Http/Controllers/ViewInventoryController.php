<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InventoryItem;

class ViewInventoryController extends Controller
{
    public function index()
    {
        $inventoryItems = InventoryItem::joinedAll();
        return view('view-inventory', compact('inventoryItems'));
    }
}

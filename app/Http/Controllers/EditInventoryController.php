<?php

namespace App\Http\Controllers;

use App\Genre;
use App\InventoryItem;
use App\InventoryItemStatus;

class EditInventoryController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $inventoryItems = InventoryItem::allNotTranslatedJoined();
        $genres = Genre::allNotTranslated();
        $inventoryStatuses = InventoryItemStatus::allTranslated();
        return view('edit-inventory', compact('inventoryItems', 'genres', 'inventoryStatuses'));
    }
}

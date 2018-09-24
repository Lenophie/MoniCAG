<?php

namespace App\Http\Controllers;

use App\Genre;
use App\InventoryItem;

class ViewInventoryController extends Controller
{
    public function index()
    {
        $inventoryItems = InventoryItem::allJoined();
        $genres = Genre::allTranslated();
        return view('view-inventory', compact('inventoryItems', 'genres'));
    }
}

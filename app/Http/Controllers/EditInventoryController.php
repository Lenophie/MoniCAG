<?php

namespace App\Http\Controllers;

use App\Genre;
use App\Http\Requests\AddInventoryItemRequest;
use App\Http\Requests\PatchInventoryItemRequest;
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
        $genres = Genre::allTranslated();
        $inventoryStatuses = InventoryItemStatus::allTranslated();
        return view('edit-inventory', compact('inventoryItems', 'genres', 'inventoryStatuses'));
    }

    public function post(AddInventoryItemRequest $request)
    {

    }

    public function patch(PatchInventoryItemRequest $request)
    {

    }
}

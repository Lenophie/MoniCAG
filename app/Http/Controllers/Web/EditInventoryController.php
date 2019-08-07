<?php

namespace App\Http\Controllers\Web;

use App\Genre;
use App\Http\Controllers\Controller;
use App\InventoryItem;
use App\InventoryItemStatus;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class EditInventoryController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        abort_unless(Gate::allows('update', InventoryItem::class), Response::HTTP_FORBIDDEN);

        $inventoryItems = InventoryItem::allNotTranslatedJoined();
        $genres = Genre::allTranslated();
        $inventoryStatuses = InventoryItemStatus::allTranslated();
        return view('edit-inventory', compact('inventoryItems', 'genres', 'inventoryStatuses'));
    }
}

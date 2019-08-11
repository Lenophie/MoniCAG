<?php

namespace App\Http\Controllers\Web;

use App\Genre;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\GenreResource;
use App\Http\Resources\Views\DetailedInventoryItemResource;
use App\InventoryItem;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class ViewInventoryController extends Controller
{
    public function index()
    {
        abort_unless(Gate::allows('viewAny', InventoryItem::class), Response::HTTP_FORBIDDEN);

        $inventoryItems = DetailedInventoryItemResource::collection(InventoryItem::all());
        $genres = GenreResource::collection(Genre::translated()->get());

        return view('view-inventory', compact('inventoryItems', 'genres'));
    }
}

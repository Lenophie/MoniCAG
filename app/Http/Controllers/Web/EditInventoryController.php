<?php

namespace App\Http\Controllers\Web;

use App\Genre;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\GenreResource;
use App\Http\Resources\API\InventoryItemStatusResource;
use App\Http\Resources\Views\DetailedInventoryItemResource;
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

        $inventoryItems = DetailedInventoryItemResource::collection(InventoryItem::with(['genres', 'altNames'])->get());
        $genres = GenreResource::collection(Genre::translated()->get());
        $inventoryStatuses = InventoryItemStatusResource::collection(InventoryItemStatus::translated()->get());

        $compactData = [
            'resources' => [
              'genres' => $genres,
              'inventoryItems' => $inventoryItems,
              'inventoryItemStatuses' => $inventoryStatuses
            ],
            'routes' => [
                'inventoryItems' => route('inventoryItems.index'),
                'genres' => route('genres.index')
            ]
        ];
        return view('edit-inventory', compact('compactData'));
    }
}

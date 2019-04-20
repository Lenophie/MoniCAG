<?php

namespace App\Http\Controllers\Web;

use App\Genre;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddInventoryItemRequest;
use App\Http\Requests\DeleteInventoryItemRequest;
use App\Http\Requests\PatchInventoryItemRequest;
use App\InventoryItem;
use App\InventoryItemStatus;
use Illuminate\Support\Facades\DB;

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
        InventoryItem::create([
            'name_fr' => htmlspecialchars(request('nameFr')),
            'name_en' => htmlspecialchars(request('nameEn')),
            'duration_min' => request('durationMin'),
            'duration_max' => request('durationMax'),
            'players_max' => request('playersMax'),
            'players_min' => request('playersMin'),
            'status_id' => InventoryItemStatus::IN_LCR_D4
        ])->genres()->attach(request('genres'));
    }

    public function patch(PatchInventoryItemRequest $request)
    {
        DB::transaction(function () {
            InventoryItem::find(request('inventoryItemId'))
                ->update([
                    'name_fr' => htmlspecialchars(request('nameFr')),
                    'name_en' => htmlspecialchars(request('nameEn')),
                    'duration_min' => request('durationMin'),
                    'duration_max' => request('durationMax'),
                    'players_max' => request('playersMax'),
                    'players_min' => request('playersMin'),
                    'status_id' => request('statusId')
                ]);
            InventoryItem::find(request('inventoryItemId'))
                ->genres()->sync(request('genres'));
        });
    }

    public function delete(DeleteInventoryItemRequest $request)
    {
        InventoryItem::destroy(request('inventoryItemId'));
    }
}
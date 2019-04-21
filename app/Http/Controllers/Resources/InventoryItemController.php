<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddInventoryItemRequest;
use App\Http\Requests\DeleteInventoryItemRequest;
use App\Http\Requests\PatchInventoryItemRequest;
use App\InventoryItem;
use App\InventoryItemStatus;
use Illuminate\Support\Facades\DB;

class InventoryItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index']);
        $this->middleware('admin')->except(['index']);
    }

    /**
     * Display a listing of inventory items.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventoryItems = InventoryItem::allJoined();
        return response($inventoryItems, 200);
    }

    /**
     * Store a newly created inventory item in storage.
     *
     * @param  \App\Http\Requests\AddInventoryItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddInventoryItemRequest $request)
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
        return response(null, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PatchInventoryItemRequest  $request
     * @param  \App\InventoryItem  $inventoryItem
     * @return \Illuminate\Http\Response
     */
    public function update(PatchInventoryItemRequest $request, InventoryItem $inventoryItem)
    {
        DB::transaction(function () use ($inventoryItem) {
            $inventoryItem->update([
                'name_fr' => htmlspecialchars(request('nameFr')),
                'name_en' => htmlspecialchars(request('nameEn')),
                'duration_min' => request('durationMin'),
                'duration_max' => request('durationMax'),
                'players_max' => request('playersMax'),
                'players_min' => request('playersMin'),
                'status_id' => request('statusId')
            ]);
            $inventoryItem->genres()->sync(request('genres'));
        });
        return response(null, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\DeleteInventoryItemRequest
     * @param  \App\InventoryItem $inventoryItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteInventoryItemRequest $request, InventoryItem $inventoryItem)
    {
        $inventoryItem->delete();
        return response(null, 200);
    }
}

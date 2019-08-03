<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateInventoryItemRequest;
use App\Http\Requests\DeleteInventoryItemRequest;
use App\Http\Requests\UpdateInventoryItemRequest;
use App\InventoryItem;
use App\InventoryItemStatus;
use Illuminate\Support\Facades\DB;

class InventoryItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('api.client:see-inventory-items')->only('index');
        $this->middleware('api.client:edit-inventory-items')->except('index');
        $this->middleware('admin')->except('index');
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
     * @param  \App\Http\Requests\CreateInventoryItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateInventoryItemRequest $request)
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
        return response([], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInventoryItemRequest  $request
     * @param  \App\InventoryItem  $inventoryItem
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInventoryItemRequest $request, InventoryItem $inventoryItem)
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
        return response([], 200);
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
        return response([], 200);
    }
}

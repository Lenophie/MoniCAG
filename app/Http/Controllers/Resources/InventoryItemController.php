<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateInventoryItemRequest;
use App\Http\Requests\DeleteInventoryItemRequest;
use App\Http\Requests\UpdateInventoryItemRequest;
use App\InventoryItem;
use App\InventoryItemStatus;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class InventoryItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index']);
    }

    /**
     * Display a listing of inventory items.
     *
     * @return Response
     */
    public function index()
    {
        abort_unless(Gate::allows('viewAny', InventoryItem::class), Response::HTTP_FORBIDDEN);
        $inventoryItems = InventoryItem::allJoined();
        return response($inventoryItems, Response::HTTP_OK);
    }

    /**
     * Store a newly created inventory item in storage.
     *
     * @param CreateInventoryItemRequest $request
     * @return Response
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
        return response([], Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateInventoryItemRequest $request
     * @param InventoryItem $inventoryItem
     * @return Response
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
        return response([], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteInventoryItemRequest
     * @param InventoryItem $inventoryItem
     * @return Response
     */
    public function destroy(DeleteInventoryItemRequest $request, InventoryItem $inventoryItem)
    {
        $inventoryItem->delete();
        return response([], Response::HTTP_OK);
    }
}

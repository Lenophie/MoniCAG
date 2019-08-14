<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateInventoryItemRequest;
use App\Http\Requests\DeleteInventoryItemRequest;
use App\Http\Requests\UpdateInventoryItemRequest;
use App\Http\Resources\API\InventoryItemCollection;
use App\Http\Resources\API\InventoryItemResource;
use App\InventoryItem;
use App\InventoryItemStatus;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class InventoryItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    /**
     * Display a listing of inventory items.
     *
     * @return InventoryItemCollection
     */
    public function index()
    {
        abort_unless(Gate::allows('viewAny', InventoryItem::class), Response::HTTP_FORBIDDEN);
        return new InventoryItemCollection(InventoryItem::all());
    }

    /**
     * Display the specified inventory item.
     *
     * @param InventoryItem $inventoryItem
     * @return InventoryItemResource
     */
    public function show(InventoryItem $inventoryItem)
    {
        abort_unless(Gate::any(['viewAny', 'view'], InventoryItem::class), Response::HTTP_FORBIDDEN);
        $inventoryItem->load(['genres', 'altNames']); // Lazy eager load the relationships after route-model binding
        return new InventoryItemResource($inventoryItem);
    }

    /**
     * Store a newly created inventory item in storage.
     *
     * @param CreateInventoryItemRequest $request
     * @return Response
     */
    public function store(CreateInventoryItemRequest $request)
    {
        DB::transaction(function () {
            // Create the inventory item
            $inventoryItem = InventoryItem::create([
                'name' => htmlspecialchars(request('name')),
                'duration_min' => request('durationMin'),
                'duration_max' => request('durationMax'),
                'players_max' => request('playersMax'),
                'players_min' => request('playersMin'),
                'status_id' => InventoryItemStatus::IN_LCR_D4
            ]);

            // Attach the inventory item's genres
            $inventoryItem->genres()->attach(request('genres'));

            // Add the inventory item alternative names
            $altNames = $this->mapAltNames(request('altNames'));
            $inventoryItem->altNames()->createMany($altNames);
        });

        return response([], Response::HTTP_CREATED);
    }

    /**
     * Update the specified inventory item in storage.
     *
     * @param UpdateInventoryItemRequest $request
     * @param InventoryItem $inventoryItem
     * @return Response
     */
    public function update(UpdateInventoryItemRequest $request, InventoryItem $inventoryItem)
    {
        DB::transaction(function () use ($inventoryItem) {
            $inventoryItem->update([
                'name' => htmlspecialchars(request('name')),
                'duration_min' => request('durationMin'),
                'duration_max' => request('durationMax'),
                'players_max' => request('playersMax'),
                'players_min' => request('playersMin'),
                'status_id' => request('statusId')
            ]);
            $inventoryItem->genres()->sync(request('genres'));

            $altNames = $this->mapAltNames(request('altNames'));
            $inventoryItem->altNames()->delete();
            $inventoryItem->altNames()->createMany($altNames);

        });
        return response([], Response::HTTP_OK);
    }

    /**
     * Remove the specified inventory item from storage.
     *
     * @param DeleteInventoryItemRequest $request
     * @param InventoryItem $inventoryItem
     * @return Response
     * @throws Exception
     */
    public function destroy(DeleteInventoryItemRequest $request, InventoryItem $inventoryItem)
    {
        $inventoryItem->delete();
        return response([], Response::HTTP_OK);
    }

    /**
     * @param $altNames array
     * @return array
     */
    private function mapAltNames($altNames) {
        return collect($altNames)->map(
            function ($item) {
                return ['name' => $item];
            }
        )->all();
    }
}

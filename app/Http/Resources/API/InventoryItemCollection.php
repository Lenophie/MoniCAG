<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class InventoryItemCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->transform(function ($inventoryItem) {
            return [
                'name' => $inventoryItem->name,
                'url' => action('Resources\InventoryItemController@show', ['id' => $inventoryItem->id])
            ];
        })->toArray();
    }
}

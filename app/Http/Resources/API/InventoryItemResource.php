<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => InventoryItemStatusResource::make($this->status)->name,
            'duration' => [
                'min' => $this->duration_min,
                'max' => $this->duration_max
            ],
            'players' => [
                'min' => $this->players_min,
                'max' => $this->players_max
            ],
            'genres' => GenreResource::collection($this->genres)->collection->pluck('name'),
            'altNames' => InventoryItemAltNameResource::collection($this->altNames)->collection->pluck('name')
        ];
    }
}

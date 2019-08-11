<?php

namespace App\Http\Resources\Views;

use App\Http\Resources\API\GenreResource;
use App\Http\Resources\API\InventoryItemAltNameResource;
use App\Http\Resources\API\InventoryItemStatusResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailedInventoryItemResource extends JsonResource
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
            'status' => InventoryItemStatusResource::make($this->status),
            'duration' => [
                'min' => $this->duration_min,
                'max' => $this->duration_max
            ],
            'players' => [
                'min' => $this->players_min,
                'max' => $this->players_max
            ],
            'genres' => GenreResource::collection($this->genres),
            'altNames' => InventoryItemAltNameResource::collection($this->altNames)
        ];
    }
}

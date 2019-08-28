<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GenreResource extends JsonResource
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
            'name' => $this->when($this->name != null, $this->name),
            'nameFr' => $this->when($this->name_fr != null, $this->name_fr),
            'nameEn' => $this->when($this->name_en != null, $this->name_en),
        ];
    }
}

<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'promotion' => $this->promotion,
            'email' => $this->email,
            'role' => $this->whenLoaded('role',
                function () {
                    return $this->role->name;
                }
            )
        ];
    }
}

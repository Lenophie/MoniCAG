<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

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
            'id' => $this->id,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'promotion' => $this->promotion,
            'email' => $this->when(
                Auth::user()->id === $this->id,
                $this->email
            ),
            'role' => $this->whenLoaded('role',
                function () {
                    return new UserRoleResource($this->role);
                }
            )
        ];
    }
}

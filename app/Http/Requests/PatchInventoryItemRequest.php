<?php

namespace App\Http\Requests;

use App\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PatchInventoryItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->role_id === UserRole::ADMINISTRATOR;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'durationMin' => 'nullable|integer|min:0',
            'durationMax' => 'nullable|integer|min:0|gte:durationMin',
            'playersMin' => 'nullable|integer|min:1',
            'playersMax' => 'nullable|integer|min:1|gte:playersMin',
            'genres' => 'required|array',
            'genres.*' => 'integer|exists:genres,id', // TO DO : make custom exist rule to get the genre name (to display it in the error)
            'nameFr' => 'required',
            'nameEn' => 'required',
            'status' => 'required|integer|exists:inventory_item_statuses,id' // TO DO : check if not changed to borrowed when status is changed by the request
        ];
    }
}

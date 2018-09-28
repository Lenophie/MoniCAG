<?php

namespace App\Http\Requests;

use App\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class AddInventoryItemRequest extends FormRequest
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
            'nameEn' => 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return Lang::get('validation/addInventoryItem');
    }
}

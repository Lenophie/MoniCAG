<?php

namespace App\Http\Requests;

use App\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

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
            'inventoryItemId' => 'required|integer|exists:inventory_items,id',
            'durationMin' => 'nullable|integer|min:0',
            'durationMax' => 'nullable|integer|min:0',
            'playersMin' => 'nullable|integer|min:1',
            'playersMax' => 'nullable|integer|min:1',
            'genres' => 'required|array',
            'genres.*' => 'integer|exists:genres,id|distinct',
            'nameFr' => 'required|unchanged_during_borrowing:inventoryItemId',
            'nameEn' => 'required|unchanged_during_borrowing:inventoryItemId',
            'statusId' => 'required|integer|exists:inventory_item_statuses,id|unchanged_during_borrowing:inventoryItemId|not_changed_to_borrowed:inventoryItemId'
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->sometimes('durationMax', 'gte:durationMin', function ($input) {
            return gettype($input->durationMin) !== 'NULL';
        })
        ->sometimes('playersMax', 'gte:playersMin', function ($input) {
            return gettype($input->playersMin) !== 'NULL';
        });
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return Lang::get('validation/patchInventoryItem');
    }
}

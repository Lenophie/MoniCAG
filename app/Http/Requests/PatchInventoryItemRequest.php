<?php

namespace App\Http\Requests;

use App\InventoryItem;
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
            'nameFr' => 'required|string|unchanged_during_borrowing:inventoryItemId',
            'nameEn' => 'required|string|unchanged_during_borrowing:inventoryItemId',
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
        })
        ->sometimes('nameFr', 'unique:inventory_items,name_fr', function ($input) {
            if (gettype($input->inventoryItemId) === 'integer') {
                $inventoryItemToPatch = InventoryItem::find($input->inventoryItemId);
                if ($inventoryItemToPatch !== null) return $inventoryItemToPatch->name_fr !== $input->nameFr;
            }
            return false;
        })
        ->sometimes('nameEn', 'unique:inventory_items,name_en', function ($input) {
            if (gettype($input->inventoryItemId) === 'integer') {
                $inventoryItemToPatch = InventoryItem::find($input->inventoryItemId);
                if ($inventoryItemToPatch !== null) return $inventoryItemToPatch->name_en !== $input->nameEn;
            }
            return false;
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

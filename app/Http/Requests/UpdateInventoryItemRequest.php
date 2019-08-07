<?php

namespace App\Http\Requests;

use App\InventoryItem;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;

class UpdateInventoryItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('update', InventoryItem::class);
    }

    protected function validationData()
    {
        return array_merge($this->request->all(), [
            'inventoryItem' => Route::input('inventoryItem')
        ]);
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
            'durationMax' => 'nullable|integer|min:0',
            'playersMin' => 'nullable|integer|min:1',
            'playersMax' => 'nullable|integer|min:1',
            'genres' => 'required|array',
            'genres.*' => 'integer|exists:genres,id|distinct',
            'nameFr' => 'bail|required|string|unchanged_during_borrowing:inventoryItem',
            'nameEn' => 'bail|required|string|unchanged_during_borrowing:inventoryItem',
            'statusId' => 'bail|required|integer|exists:inventory_item_statuses,id|unchanged_during_borrowing:inventoryItem|not_changed_to_borrowed:inventoryItem'
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
        // If the name is different from the current, check if it is unique
        ->sometimes('nameFr', 'unique:inventory_items,name_fr', function ($input) {
            return $input->inventoryItem->name_fr !== $input->nameFr;
        })
        ->sometimes('nameEn', 'unique:inventory_items,name_en', function ($input) {
            return $input->inventoryItem->name_en !== $input->nameEn;
        });
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return Lang::get('validation/updateInventoryItem');
    }
}

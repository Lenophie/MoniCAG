<?php

namespace App\Http\Requests;

use App\InventoryItem;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Validator;

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

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
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
            'name' => 'bail|required|string|unchanged_during_borrowing:inventoryItem',
            'durationMin' => 'nullable|integer|min:0',
            'durationMax' => 'nullable|integer|min:0',
            'playersMin' => 'nullable|integer|min:1',
            'playersMax' => 'nullable|integer|min:1',
            'genres' => 'required|array',
            'genres.*' => 'integer|exists:genres,id|distinct',
            'altNames' => 'array',
            'altNames.*' => 'string|distinct',
            'statusId' => 'bail|required|integer|exists:inventory_item_statuses,id|unchanged_during_borrowing:inventoryItem|not_changed_to_borrowed:inventoryItem'
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  Validator  $validator
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
        ->sometimes('name', 'unique:inventory_items,name', function ($input) {
            return $input->inventoryItem->name !== $input->name;
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

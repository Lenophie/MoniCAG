<?php

namespace App\Http\Requests;

use App\InventoryItem;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\Validator;

class CreateInventoryItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create', InventoryItem::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|unique:inventory_items,name',
            'durationMin' => 'nullable|integer|min:0',
            'durationMax' => 'nullable|integer|min:0',
            'playersMin' => 'nullable|integer|min:1',
            'playersMax' => 'nullable|integer|min:1',
            'genres' => 'required|array',
            'genres.*' => 'integer|exists:genres,id|distinct',
            'altNames' => 'array',
            'altNames.*' => 'string|distinct'
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
        });
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return Lang::get('validation/createInventoryItem');
    }
}

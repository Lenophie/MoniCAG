<?php

namespace App\Http\Requests;

use App\InventoryItemStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewBorrowingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'borrowedItems' => 'required|array',
            'borrowedItems.*' => 'integer|inventory_item_available',
            'startDate' => 'required|date_format:d/m/Y|after_or_equal:today',
            'expectedReturnDate' => 'required|date_format:d/m/Y|after_or_equal:startDate',
            'guarantee' => 'required|numeric|min:0',
            'agreementCheck1' => 'required',
            'agreementCheck2' => 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [

        ];
    }
}

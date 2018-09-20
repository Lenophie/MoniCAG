<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'guarantee' => 'required|numeric|regex:/^[0-9]+([.,][0-9][0-9]?)?$/',
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

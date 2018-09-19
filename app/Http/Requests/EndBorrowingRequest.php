<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EndBorrowingRequest extends FormRequest
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
            'selectedBorrowings' => 'required|array',
            'selectedBorrowings.*' => 'integer',
            'newInventoryItemsStatus' => 'required|integer'
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
            'selectedBorrowings.required' => 'Sélectionnez des emprunts à terminer.'
        ];
    }
}

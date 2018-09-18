<?php

namespace App\Http\Requests;

use http\Env\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

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
            'borrowedItems.*' => 'integer',
            'startDate' => 'required|date_format:d/m/Y|after_or_equal:today',
            'expectedReturnDate' => 'required|date_format:d/m/Y|after_or_equal:startDate',
            'guarantee' => 'required|numeric|positive',
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
            'borrowedItems.required' => 'Sélectionnez des jeux à emprunter.',
            'startDate.required'  => 'Renseignez une date de début d\'emprunt.',
            'startDate.after_or_equal' => 'La date d\'emprunt ne peut pas être inférieure à la date du jour.',
            'expectedReturnDate.required'  => 'Renseignez une date de retour prévu.',
            'expectedReturnDate.after_or_equal' => 'La date de retour prévu doit être supérieure ou égale à la date d\'emprunt.',
            'guarantee.required' => 'Renseignez la caution.',
            'guarantee.numeric' => 'La caution doit être un nombre positif.',
            'guarantee.positive' => 'La caution doit être un nombre positif.',
            'agreementCheck1.required' => 'Cet engagement est obligatoire.',
            'agreementCheck2.required' => 'Cet engagement est obligatoire.'
        ];
    }
}

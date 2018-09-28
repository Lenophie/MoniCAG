<?php

namespace App\Http\Requests;

use App\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class NewBorrowingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->role_id === UserRole::LENDER || Auth::user()->role_id === UserRole::ADMINISTRATOR;
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
            'borrowerEmail' => 'required|email|exists:users,email',
            'borrowerPassword' => 'required|password_for:borrowerEmail',
            'startDate' => 'required|date_format:d/m/Y|after_or_equal:today',
            'expectedReturnDate' => 'required|date_format:d/m/Y|after_or_equal:startDate',
            'guarantee' => 'required|numeric|regex:/^[0-9]+([.,][0-9][0-9]?)?$/',
            'agreementCheck1' => 'required|accepted',
            'agreementCheck2' => 'required|accepted'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return Lang::get('validation/newBorrowing');
    }
}

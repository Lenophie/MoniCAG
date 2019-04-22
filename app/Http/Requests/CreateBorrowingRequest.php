<?php

namespace App\Http\Requests;

use App\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class CreateBorrowingRequest extends FormRequest
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
            'borrowedItems.*' => 'bail|integer|exists:inventory_items,id|distinct|inventory_item_available',
            'borrowerEmail' => 'required|email|exists:users,email',
            'borrowerPassword' => 'required|password_for:borrowerEmail',
            'expectedReturnDate' => 'required|date_format:Y-m-d|after_or_equal:today|before_or_equal:+1 month',
            'guarantee' => 'required|numeric|regex:/^[0-9]+(.[0-9][0-9]?)?$/|max:1000',
            'agreementCheck1' => 'required|accepted',
            'agreementCheck2' => 'required|accepted',
            'notes' => 'nullable|string'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return Lang::get('validation/createBorrowing');
    }
}

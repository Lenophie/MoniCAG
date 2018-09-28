<?php

namespace App\Http\Requests;

use App\InventoryItemStatus;
use App\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\Rule;

class EndBorrowingRequest extends FormRequest
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
            'selectedBorrowings' => 'required|array',
            'selectedBorrowings.*' => 'integer|distinct',
            'newInventoryItemsStatus' => [
                'required',
                'integer',
                'exists:inventory_item_statuses,id',
                Rule::in([InventoryItemStatus::IN_LCR_D4, InventoryItemStatus::LOST])
            ]
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return Lang::get('validation/endBorrowing');
    }
}

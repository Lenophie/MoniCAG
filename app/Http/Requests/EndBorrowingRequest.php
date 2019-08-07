<?php

namespace App\Http\Requests;

use App\Borrowing;
use App\InventoryItemStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
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
        return Gate::allows('return', Borrowing::class);
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
            'selectedBorrowings.*' => 'bail|integer|exists:borrowings,id|distinct|not_already_returned|no_self_return',
            'newInventoryItemsStatus' => [
                'required',
                'integer',
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

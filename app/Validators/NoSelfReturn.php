<?php

namespace App\Validators;

use App\Borrowing;
use Illuminate\Support\Facades\Auth;

class NoSelfReturn
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $borrowerId = Borrowing::find($value)->borrower_id;
        return $borrowerId !== Auth::user()->id;
    }
}
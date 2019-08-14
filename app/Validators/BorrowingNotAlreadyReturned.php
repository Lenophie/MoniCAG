<?php

namespace App\Validators;

use App\Borrowing;
use App\Validators\Replacers\ReplaceUserAndItemWithBorrowingId;

class BorrowingNotAlreadyReturned
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $validator->addReplacer('not_already_returned', function ($message, $attribute, $rule, $parameters) use ($value) {
            return ReplaceUserAndItemWithBorrowingId::replace($message, $value);
        });

        $isNotAlreadyReturned = Borrowing::find($value)->return_date === null;
        return $isNotAlreadyReturned;
    }
}

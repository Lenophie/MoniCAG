<?php

namespace App\Validators;

class NotInvolvedInACurrentBorrowing
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $modifiedUser = $value;
        if ($modifiedUser->borrowings()->whereNull('return_date')->count() > 0) return false;
        if ($modifiedUser->lendings()->whereNull('return_date')->count() > 0) return false;
        return true;
    }
}

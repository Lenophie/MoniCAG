<?php

namespace App\Validators;

class NotInvolvedInACurrentBorrowing
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $modifiedUser = $value;
        if ($modifiedUser->borrowings()->where('finished', 0)->count() > 0) return false;
        if ($modifiedUser->lendings()->where('finished', 0)->count() > 0) return false;
        return true;
    }
}

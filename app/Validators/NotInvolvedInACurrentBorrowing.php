<?php

namespace App\Validators;

use App\User;
use App\UserRole;
use Illuminate\Support\Facades\Auth;

class NotInvolvedInACurrentBorrowing
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $modifiedUser = User::find($value);
        if ($modifiedUser->borrowings()->where('finished', 0)->count() > 0) return false;
        if ($modifiedUser->lendings()->where('finished', 0)->count() > 0) return false;
        return true;
    }
}
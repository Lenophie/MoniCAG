<?php

namespace App\Validators;

use App\UserRole;
use Illuminate\Support\Facades\Auth;

class UnchangedIfOtherAdmin
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $modifiedUser = $value;
        if ($modifiedUser->id === Auth::user()->id) return true;
        if ($modifiedUser->role_id !== UserRole::ADMINISTRATOR) return true;
        return false;
    }
}

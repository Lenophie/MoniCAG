<?php

namespace App\Validators;

use App\User;
use App\UserRole;
use Illuminate\Support\Facades\Auth;

class UnchangedIfOtherAdmin
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $modifiedUser = User::find($value);
        if ($modifiedUser) {
            if ($modifiedUser->id === Auth::user()->id) return true;
            if ($modifiedUser->role_id !== UserRole::ADMINISTRATOR) return true;
        }
        return false;
    }
}
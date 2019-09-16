<?php

namespace App\Validators;

use App\User;
use App\UserRole;

class NotASuperAdmin
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $borrower = User::select('role_id')->where('email', $value)->first();

        if ($borrower != null && $borrower->role_id != UserRole::SUPER_ADMINISTRATOR) return true;
        return false;
    }
}

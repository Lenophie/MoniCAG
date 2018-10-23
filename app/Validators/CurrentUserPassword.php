<?php

namespace App\Validators;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CurrentUserPassword
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        return Hash::check($value, Auth::user()->password);
    }
}
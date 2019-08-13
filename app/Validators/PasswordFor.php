<?php

namespace App\Validators;

use App\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class PasswordFor
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $email = Arr::get($validator->getData(), $parameters[0]);
        $user = User::where('email', $email)->select('password')->first();
        if ($user !== null) {
            $password = $user->password;
            return Hash::check($value, $password);
        }
        return false;
    }
}

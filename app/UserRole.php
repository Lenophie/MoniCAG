<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class UserRole extends Model
{
    public $timestamps = false;
    public const NONE = 1;
    public const LENDER = 2;
    public const ADMINISTRATOR = 3;

    public static function allTranslated() {
        $userRoles = UserRole::select('id', 'name_'.App::getLocale().' AS name')
            ->orderBy('id')
            ->get();

        return $userRoles;
    }
}

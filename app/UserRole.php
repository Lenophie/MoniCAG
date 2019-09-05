<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\App;

class UserRole extends Model
{
    public $timestamps = false;
    public const NONE = 1;
    public const LENDER = 2;
    public const ADMINISTRATOR = 3;

    /**
     * @return Builder
     */
    public static function translated() {
        $userRoles = UserRole::select('id', 'name_'.App::getLocale().' AS name')->orderBy('id');

        return $userRoles;
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    public $timestamps = false;
    public const NONE = 1;
    public const LENDER = 2;
    public const ADMINISTRATOR = 3;
}

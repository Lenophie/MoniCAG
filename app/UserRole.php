<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    public $timestamps = false;
    public const AUCUN = 1;
    public const PRETEUR = 2;
    public const ADMINISTRATEUR = 3;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BorrowingStatus extends Model
{
    public $timestamps = false;
    public const EN_COURS = 1;
    public const TERMINE = 2;
    public const ANNULE = 3;
}

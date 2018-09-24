<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryItemStatus extends Model
{
    public $timestamps = false;
    public const IN_LCR_D4 = 1;
    public const IN_F2 = 2;
    public const BORROWED = 3;
    public const LOST = 4;
    public const UNKNOWN = 5;
}

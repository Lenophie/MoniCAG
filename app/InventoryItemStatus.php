<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryItemStatus extends Model
{
    public $timestamps = false;
    public const AU_LOCAL_LCR_D4 = 1;
    public const AU_LOCAL_F2 = 2;
    public const EMPRUNTE = 3;
    public const PERDU = 4;
    public const INCONNU = 5;
}

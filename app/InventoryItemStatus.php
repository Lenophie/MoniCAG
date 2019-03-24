<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class InventoryItemStatus extends Model
{
    public $timestamps = false;
    public const IN_LCR_D4 = 1;
    public const IN_F2 = 2;
    public const BORROWED = 3;
    public const LOST = 4;
    public const UNKNOWN = 5;


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public static function allTranslated() {
        $statuses = InventoryItemStatus::select('id', 'name_'.App::getLocale().' AS name')
            ->get();
        return $statuses;
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
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
     * @return Collection
     */
    public static function allTranslated() {
        $statuses = InventoryItemStatus::selectLocale()->get();
        return $statuses;
    }

    /**
     * @return Builder
     */
    private static function selectLocale() {
        return InventoryItemStatus::select('id', 'name_'.App::getLocale().' AS name');
    }
}

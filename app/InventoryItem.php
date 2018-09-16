<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    public static function joinedAll() {
        return DB::table('inventory_items as ii')
            ->leftJoin('inventory_item_statuses as iis', 'iis.id', '=', 'ii.status_id')
            ->select('ii.id as id', 'ii.name as name', 'ii.status_id as status_id', 'iis.name as status')
            ->get();
    }
}

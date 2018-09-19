<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InventoryItem extends Model
{
    /**
     * Get the inventory item belonging to the borrowing.
     */
    public function borrowing()
    {
        return $this->belongsTo('App\Borrowing', 'id', 'inventory_item_id');
    }

    public static function joinedAll() {
        return DB::table('inventory_items as ii')
            ->leftJoin('inventory_item_statuses as iis', 'iis.id', '=', 'ii.status_id')
            ->select('ii.id as id', 'ii.name as name', 'ii.status_id as status_id', 'iis.name as status')
            ->get();
    }
}

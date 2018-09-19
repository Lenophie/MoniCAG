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

    /**
     * Get the inventory item status.
     */
    public function status()
    {
        return $this->hasOne('App\InventoryItemStatus', 'id', 'status_id');
    }

    public static function allJoined() {
        $inventoryItems = InventoryItem::with(['status'])
            ->select('id', 'name', 'status_id')
            ->get();

        foreach($inventoryItems as $inventoryItem) {
            unset($inventoryItem->status_id);
        }

        return $inventoryItems;
    }
}

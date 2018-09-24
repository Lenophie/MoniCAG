<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
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
     * Get the inventory item genres.
     */
    public function genres()
    {
        return $this->belongsToMany('App\Genre')->select('name_'.App::getLocale().' AS name')->orderBy('name');
    }

    /**
     * Get the inventory item status.
     */
    public function status()
    {
        return $this->hasOne('App\InventoryItemStatus', 'id', 'status_id')
            ->select('id', 'name_'.App::getLocale().' AS name');
    }

    public static function allJoined() {
        $inventoryItems = InventoryItem::with(['status', 'genres'])
            ->select('id',
                'name_'.App::getLocale().' AS name',
                'status_id',
                'duration_min',
                'duration_max',
                'players_min',
                'players_max')
            ->get();

        foreach($inventoryItems as $inventoryItem) {
            unset($inventoryItem->status_id);
            $inventoryItem->duration = [
                'min' => $inventoryItem->duration_min,
                'max' => $inventoryItem->duration_max
            ];
            unset($inventoryItem->duration_min);
            unset($inventoryItem->duration_max);
            $inventoryItem->players = [
                'min' => $inventoryItem->players_min,
                'max' => $inventoryItem->players_max
            ];
            unset($inventoryItem->players_min);
            unset($inventoryItem->players_max);
        }

        return $inventoryItems;
    }
}

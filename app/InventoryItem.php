<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class InventoryItem extends Model
{
    /**
     * Always capitalize the first letter of each word of the french name when setting it
     */
    public function setNameFrAttribute($value) {
        $this->attributes['name_fr'] = ucwords($value);
    }

    /**
     * Always capitalize the first letter of each word of the french name when setting it
     */
    public function setNameEnAttribute($value) {
        $this->attributes['name_en'] = ucwords($value);
    }

    /**
     * Get the inventory item belonging to the borrowing.
     */
    public function borrowing() {
        return $this->belongsTo('App\Borrowing', 'id', 'inventory_item_id');
    }

    /**
     * Get the inventory item genres.
     */
    public function genres() {
        return $this->belongsToMany('App\Genre')->select('name_'.App::getLocale().' AS name')->orderBy('name');
    }

    /**
     * Get the inventory item status.
     */
    public function status() {
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
            ->orderBy('name')
            ->get();

        foreach($inventoryItems as $inventoryItem) {
            unset($inventoryItem->status_id);
            $inventoryItem->duration = (object) [
                'min' => $inventoryItem->duration_min,
                'max' => $inventoryItem->duration_max
            ];
            unset($inventoryItem->duration_min);
            unset($inventoryItem->duration_max);
            $inventoryItem->players = (object) [
                'min' => $inventoryItem->players_min,
                'max' => $inventoryItem->players_max
            ];
            unset($inventoryItem->players_min);
            unset($inventoryItem->players_max);
        }

        return $inventoryItems;
    }

    public static function allNotTranslatedJoined() {
        $inventoryItems = InventoryItem::with(['status', 'genres'])
            ->orderBy('name_fr')
            ->get();

        foreach($inventoryItems as $inventoryItem) {
            unset($inventoryItem->status_id);
            $inventoryItem->duration = (object) [
                'min' => $inventoryItem->duration_min,
                'max' => $inventoryItem->duration_max
            ];
            unset($inventoryItem->duration_min);
            unset($inventoryItem->duration_max);
            $inventoryItem->players = (object) [
                'min' => $inventoryItem->players_min,
                'max' => $inventoryItem->players_max
            ];
            unset($inventoryItem->players_min);
            unset($inventoryItem->players_max);
        }

        return $inventoryItems;
    }
}

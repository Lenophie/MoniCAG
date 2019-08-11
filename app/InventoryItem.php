<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class InventoryItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'duration_min',
        'duration_max',
        'players_min',
        'players_max',
        'status_id'
    ];

    /**
     * Always capitalize the first letter of each word of the main name when setting it
     */
    public function setNameAttribute($value) {
        $this->attributes['name'] = ucwords($value);
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
        return $this->belongsToMany('App\Genre')->select('genres.id', 'name_'.App::getLocale().' AS name')->orderBy('name');
    }

    /**
     * Get the inventory item status.
     */
    public function status() {
        return $this->hasOne('App\InventoryItemStatus', 'id', 'status_id')
            ->select('id', 'name_'.App::getLocale().' AS name');
    }

    public function altNames() {
        return $this->hasMany('App\InventoryItemAltName');
    }

    public static function allJoined() {
        $inventoryItems = InventoryItem::with(['status', 'genres', 'altNames'])
            ->select('id',
                'name',
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
}

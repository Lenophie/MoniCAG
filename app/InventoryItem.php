<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
     * @param $value
     */
    public function setNameAttribute($value) {
        $this->attributes['name'] = ucwords($value);
    }

    /**
     * Get the inventory item belonging to the borrowing.
     * @return BelongsTo
     */
    public function borrowing() {
        return $this->belongsTo('App\Borrowing', 'id', 'inventory_item_id');
    }

    /**
     * Get the inventory item's genres.
     * @return BelongsToMany
     */
    public function genres() {
        return $this->belongsToMany('App\Genre')->select('genres.id', 'name_'.App::getLocale().' AS name')->orderBy('name');
    }

    /**
     * Get the inventory item's status.
     * @return HasOne
     */
    public function status() {
        return $this->hasOne('App\InventoryItemStatus', 'id', 'status_id')
            ->select('id', 'name_'.App::getLocale().' AS name');
    }

    /**
     * Get the inventory item's alternative names.
     * @return HasMany
     */
    public function altNames() {
        return $this->hasMany('App\InventoryItemAltName');
    }
}

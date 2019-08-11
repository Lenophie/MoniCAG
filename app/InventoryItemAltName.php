<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryItemAltName extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'inventory_item_id',
        'name'
    ];

    /**
     * Always capitalize the first letter of each word of the name when setting it
     * @param $value
     */
    public function setNameAttribute($value) {
        $this->attributes['name'] = ucwords($value);
    }
}

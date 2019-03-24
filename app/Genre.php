<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Genre extends Model
{
    public $timestamps = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public static function allTranslated() {
        $genres = Genre::select('id', 'name_'.App::getLocale().' AS name')
            ->orderBy('name')
            ->get();
        return $genres;
    }

    public static function allNotTranslated() {
        $genres = Genre::orderBy('name_fr')
            ->get();
        return $genres;
    }
}

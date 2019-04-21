<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Genre extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_fr',
        'name_en'
    ];

    public $timestamps = false;

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

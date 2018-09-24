<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Genre extends Model
{
    public $timestamps = false;

    public static function allTranslated() {
        $genres = Genre::select('id', 'name_'.App::getLocale().' AS name')->get();
        return $genres;
    }
}

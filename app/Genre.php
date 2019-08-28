<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
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

    /**
     * @return Builder
     */
    public static function translated() {
        return Genre::select('id', 'name_'.App::getLocale().' AS name')
            ->orderBy('name');
    }

    /**
     * @return Builder
     */
    public static function plusTranslated() {
        return Genre::select('id', 'name_'.App::getLocale().' AS name', 'name_fr', 'name_en')->orderBy('name');
    }
}

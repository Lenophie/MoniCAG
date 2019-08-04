<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class LangController extends Controller
{
    // Credit to https://medium.com/@serhii.matrunchyk/using-laravel-localization-with-javascript-and-vuejs-23064d0c210e)
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lang = config('app.locale');

        $files   = glob(resource_path('lang/' . $lang . '/*.php'));
        $strings = [];

        foreach ($files as $file) {
            $name           = basename($file, '.php');
            $strings[$name] = require $file;
        }

        $simpleWordsJson = json_decode(file_get_contents(resource_path('lang/fr.json')));
        foreach ($simpleWordsJson as $key => $value) {
            $strings[$key] = $value;
        }

        return response($strings, 200);
    }
}

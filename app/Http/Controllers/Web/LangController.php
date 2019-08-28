<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class LangController extends Controller
{
    // Credit to https://medium.com/@serhii.matrunchyk/using-laravel-localization-with-javascript-and-vuejs-23064d0c210e)
    /**
     * @return Response
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

        $simpleWordsFileName = resource_path('lang/' . $lang . '.json');
        if (file_exists($simpleWordsFileName)) {
            $simpleWordsJson = json_decode(file_get_contents($simpleWordsFileName));
            foreach ($simpleWordsJson as $key => $value) {
                $strings[$key] = $value;
            }
        }

        return response($strings, Response::HTTP_OK);
    }
}

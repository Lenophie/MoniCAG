<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguagesController extends Controller
{
    public function index() {
        $lang = App::getLocale();
        return redirect('/storage/lang/' . $lang . '.json');
    }

    public function change($locale) {
        Session::put('locale_lang', $locale);
        return redirect()->back();
    }
}

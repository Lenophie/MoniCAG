<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class LanguagesController extends Controller
{
    public function change($locale) {
        Session::put('locale_lang', $locale);
        return redirect()->back();
    }
}

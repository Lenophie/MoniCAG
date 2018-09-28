<?php

namespace App\Http\Controllers;

class LanguagesController extends Controller
{
    public function change($locale) {
        session(['locale_lang' => $locale]);
        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class ThemesController extends Controller
{
    public function change($name) {
        Session::put('theme', $name);
        return redirect()->back();
    }
}

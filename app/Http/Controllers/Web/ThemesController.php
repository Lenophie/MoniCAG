<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ThemesController extends Controller
{
    public function change($name) {
        Session::put('theme', $name);
        return redirect()->back();
    }
}

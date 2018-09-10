<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LenderController extends Controller
{
    public function index()
    {
        return view('lender');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewInventoryController extends Controller
{
    public function index()
    {
        return view('view-inventory');
    }
}

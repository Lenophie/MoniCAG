<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EditInventoryController extends Controller
{
    public function index()
    {
        return view('edit-inventory');
    }
}

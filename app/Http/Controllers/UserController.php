<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        return view('user');
    }
}

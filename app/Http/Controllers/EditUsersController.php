<?php

namespace App\Http\Controllers;

class EditUsersController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        return view('edit-users');
    }
}

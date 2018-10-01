<?php

namespace App\Http\Controllers;

use App\User;
use App\UserRole;

class EditUsersController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $users = User::allSelected();
        $userRoles = UserRole::allTranslated();
        return view('edit-users', compact('users', 'userRoles'));
    }

    public function patch()
    {

    }

    public function delete()
    {

    }
}

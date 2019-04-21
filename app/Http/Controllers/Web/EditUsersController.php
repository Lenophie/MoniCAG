<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
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
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\PatchUserRequest;
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

    public function patch(PatchUserRequest $request)
    {
        User::find(request('userId'))
            ->update([
                'role_id' => request('role')
            ]);
    }

    public function delete(DeleteUserRequest $request)
    {
        User::destroy(request('userId'));
    }
}

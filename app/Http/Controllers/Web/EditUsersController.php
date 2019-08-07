<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\User;
use App\UserRole;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class EditUsersController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        abort_unless(Gate::allows('viewAny', User::class), Response::HTTP_FORBIDDEN);

        $users = User::allSelected();
        $userRoles = UserRole::allTranslated();
        return view('edit-users', compact('users', 'userRoles'));
    }
}

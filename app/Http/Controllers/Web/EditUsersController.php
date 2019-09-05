<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\UserResource;
use App\Http\Resources\API\UserRoleResource;
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

        $users = UserResource::collection(User::all());
        $userRoles = UserRoleResource::collection(UserRole::translated()->get());

        $compactData = [
            'resources' => [
                'users' => $users,
                'userRoles' => $userRoles
            ],
            'routes' => [
                'users' => route('users.index')
            ]
        ];

        return view('edit-users', compact('compactData'));
    }
}

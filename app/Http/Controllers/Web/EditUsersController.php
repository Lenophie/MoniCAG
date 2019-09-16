<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\UserResource;
use App\Http\Resources\API\UserRoleResource;
use App\User;
use App\UserRole;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class EditUsersController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        abort_unless(Gate::allows('viewAny', User::class), Response::HTTP_FORBIDDEN);

        $usersQuery = User::where('role_id', '!=', UserRole::SUPER_ADMINISTRATOR)->get();
        $users = UserResource::collection($usersQuery);

        $userRolesQuery = UserRole::translated()
            ->where('id', '!=', UserRole::SUPER_ADMINISTRATOR)
            ->get();
        $userRoles = UserRoleResource::collection($userRolesQuery);

        $loggedUser = Auth::user();

        $compactData = [
            'resources' => [
                'users' => $users,
                'userRoles' => $userRoles,
                'loggedUser' => [
                    'id' => $loggedUser->id,
                    'isSuperAdmin' => $loggedUser->role_id == UserRole::SUPER_ADMINISTRATOR
                ],
            ],
            'routes' => [
                'users' => route('users.index')
            ]
        ];

        return view('edit-users', compact('compactData'));
    }
}

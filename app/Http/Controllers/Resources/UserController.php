<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\UpdateUserRoleRequest;
use App\Http\Resources\API\UserResource;
use App\User;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of users.
     *
     * @return Response
     */
    public function index()
    {
        abort_unless(Gate::allows('viewAny', User::class), Response::HTTP_FORBIDDEN);
        $users = UserResource::collection(User::orderByName()->get());
        return response($users, Response::HTTP_OK);
    }

    /**
     * Display the specified user.
     *
     * @param User $user
     * @return UserResource
     */
    public function show(User $user)
    {
        abort_unless(
            Gate::allows('viewAny', User::class) || Gate::allows('view', $user),
            Response::HTTP_FORBIDDEN);
        return new UserResource($user);
    }

    /**
     * Update the user role of the specified user.
     *
     * @param UpdateUserRoleRequest $request
     * @param User $user
     * @return Response
     */
    public function updateRole(UpdateUserRoleRequest $request, User $user) {
        $user->update(['role_id' => request('role')]);
        return response([], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteUserRequest $request
     * @param User $user
     * @return Response
     * @throws Exception
     */
    public function destroy(DeleteUserRequest $request, User $user)
    {
        $user->delete();
        return response([], Response::HTTP_OK);
    }
}

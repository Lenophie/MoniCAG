<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\UpdateUserRoleRequest;
use App\User;
use Exception;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
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
     * @param DeleteUserRequest
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

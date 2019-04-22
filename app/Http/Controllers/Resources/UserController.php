<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\UpdateUserRoleRequest;
use App\User;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
        $this->middleware('admin');
    }

    public function changeRole(UpdateUserRoleRequest $request, User $user) {
        $user->update(['role_id' => request('role')]);
        return response([], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\DeleteUserRequest
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteUserRequest $request, User $user)
    {
        $user->delete();
        return response([], 200);
    }
}

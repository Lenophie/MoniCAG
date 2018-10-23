<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteAccountRequest;
use App\User;
use Illuminate\Support\Facades\Auth;

class DeleteAccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function delete(DeleteAccountRequest $request)
    {
        User::destroy(Auth::user()->id);
    }
}

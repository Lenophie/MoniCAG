<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
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

    public function index()
    {
        return view('auth/passwords/change');
    }

    public function post(ChangePasswordRequest $request)
    {
        Auth::user()->update([
            'password' => Hash::make(request('newPassword'))
        ]);
        Auth::user()->save();
        return redirect('/');
    }
}

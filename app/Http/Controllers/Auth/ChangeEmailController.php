<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeEmailRequest;
use Illuminate\Support\Facades\Auth;

class ChangeEmailController extends Controller
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
        return view('auth/emails/change');
    }

    public function post(ChangeEmailRequest $request)
    {
        Auth::user()->update([
            'email' => request('email')
        ]);
        Auth::user()->save();
        return redirect('/');
    }
}

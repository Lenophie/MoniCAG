<?php

namespace App\Http\Middleware;

use App\UserRole;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class LenderMiddleware
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user_role_id = $this->auth->getUser()->role_id;
        if ($user_role_id !== UserRole::LENDER && $user_role_id !== UserRole::ADMINISTRATOR) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}

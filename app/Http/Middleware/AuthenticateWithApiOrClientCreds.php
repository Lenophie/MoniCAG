<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as AuthGuardMiddleware;
use Laravel\Passport\Http\Middleware\CheckClientCredentials as ClientCredMiddleware;


class AuthenticateWithApiOrClientCreds
{
    /**
    * Authenticate a request with either Authenticate OR CheckClientCredentials Middleware
    *
    * @param $request
    * @param Closure $next
    * @param  mixed  ...$scopes
    * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
    */
    public function handle($request, Closure $next, ...$scopes)
    {
        try {
            $auth_guard_middleware  = app()->make(AuthGuardMiddleware::class);
            $response = $auth_guard_middleware->handle($request, $next, 'api');
        } catch (AuthenticationException $e) {
            $client_cred_middleware = app()->make(ClientCredMiddleware::class);
            $response = $client_cred_middleware->handle($request, $next, ...$scopes);
        }

        return $response;
    }
}

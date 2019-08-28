<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ApiLocalization
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $local = $request->hasHeader("X-Localization") ?
            $request->header("X-Localization") : config('app.locale');
        App::setLocale($local);
        return $next($request);
    }
}

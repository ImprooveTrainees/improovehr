<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class managerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::User()->idusertype != 2) {
            abort(403, "You don't have the necessary permissions do access this page");
        }

        return $next($request);
    }
}

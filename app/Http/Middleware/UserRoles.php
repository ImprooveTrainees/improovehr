<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class UserRoles
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
        if (Auth::User()->idusertype != 1 && Auth::User()->idusertype != 2 && Auth::User()->idusertype != 3) {
            abort(403, "You don't have the necessary permissions do access this page");
        }

        return $next($request);
    }
}

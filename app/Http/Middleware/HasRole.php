<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class HasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (Auth::user()->has_role($role)) {
            abort(500);
        }
        // if (! $request->user()->has_role($role)) {
        //     abort(401);
        // }

        return $next($request);
    }
}

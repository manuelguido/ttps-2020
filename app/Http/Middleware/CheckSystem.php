<?php

namespace App\Http\Middleware;

use Closure;

class CheckSystem
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $system)
    {
        if(! $request->user()->hasSystem($system)) {
            abort(403);
        }

        return $next($request);
    }
}

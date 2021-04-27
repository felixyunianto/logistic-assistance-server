<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Level
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
        if(Auth::user()->level === 'Admin') {
            return $next($request);
        }

        abort(403, "Tidak memiliki akses ini.");
    }
}

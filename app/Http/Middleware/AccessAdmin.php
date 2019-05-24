<?php

namespace App\Http\Middleware;
use Auth;

use Closure;

class AccessAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$role)
    {
        
        if (\Auth::user()->hasAnyroles($role)) {
            return $next($request);
        }

        return redirect('/404');
    }
}

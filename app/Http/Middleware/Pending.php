<?php

namespace App\Http\Middleware;

use Closure;
use Gate;

class Pending
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
	    if (Gate::denies('view-passwords')) {
		    return redirect('/');
	    }
	    
        return $next($request);
    }
}

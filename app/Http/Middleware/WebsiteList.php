<?php

namespace App\Http\Middleware;

use Closure;
use Gate;

class websitelist
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
	    if (Gate::denies('view-websites')) {
		    return redirect('/');
	    }
	    
        return $next($request);
    }
}

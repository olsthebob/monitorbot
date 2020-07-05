<?php

namespace App\Http\Middleware;

use Closure;

class HasOrganisation
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
        if (empty($request->user()->organisation)) {
            return redirect('/organisation/new');
        }

        return $next($request);
    }
}

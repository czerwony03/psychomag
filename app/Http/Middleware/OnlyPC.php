<?php

namespace App\Http\Middleware;

use Closure;
use Jenssegers\Agent\Facades\Agent;

class OnlyPC
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
        if (Agent::isMobile()) {
            return abort(403, 'Dostęp do testów jest możliwy tylko z poziomu komputera (PC).');
        }
        return $next($request);
    }
}

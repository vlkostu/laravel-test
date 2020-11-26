<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class ApiRequestHit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        # Increment total
        Cache::increment('api-total-requests');
        # Increment auth user
        if (!auth()->guest()) Cache::increment('api:users:'.auth()->id());

        return $next($request);
    }
}

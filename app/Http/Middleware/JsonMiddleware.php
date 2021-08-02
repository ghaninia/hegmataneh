<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str ;

class JsonMiddleware
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
        $acceptHeader = $request->headers->get('Accept');
        if (!Str::contains($acceptHeader, 'application/json')) {
            $newAcceptHeader = 'application/json';
            if ($acceptHeader) {
                $newAcceptHeader .= "/$acceptHeader";
            }
            $request->headers->set('Accept', $newAcceptHeader);
        }
        return $next($request);
    }
}

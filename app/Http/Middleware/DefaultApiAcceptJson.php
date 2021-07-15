<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class DefaultApiAcceptJson
{

    /*
    ** تغییر در هدر
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

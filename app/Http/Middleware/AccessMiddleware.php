<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Core\Traits\MessageTrait;
use Illuminate\Support\Facades\Route;
use App\Services\Authunticate\AuthService;

class AccessMiddleware
{
    use MessageTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $result = app(AuthService::class)
            ->can("f_ability", $request->route()->getActionMethod());

        return $result ? $next($request) : $this->error([
            "msg" => trans("dashboard.error.authunticate.unauthorize")
        ]);
    }
}

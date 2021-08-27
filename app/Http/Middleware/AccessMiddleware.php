<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Core\Traits\MessageTrait;
use Illuminate\Support\Facades\Gate;

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
        $action = $request->route()->getAction()["uses"];
        $user = $request->user();

        $result = Gate::forUser($user)->allows("f_ability", $action );

        return $result ? $next($request) : $this->error([
            "msg" => trans("dashboard.error.authunticate.unauthorize")
        ]);
    }
}

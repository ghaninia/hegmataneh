<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Kernel\Response\Traits\ResponseMessageTrait;

class AccessMiddleware
{
    use ResponseMessageTrait;

    /**
     * Handle an incoming request
     * @param Request $request
     * @param Closure $next
     * @return \Illuminate\Http\JsonResponse|mixed
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

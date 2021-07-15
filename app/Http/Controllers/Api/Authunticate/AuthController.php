<?php

namespace App\Http\Controllers\Api\Authunticate;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Services\Authunticate\AuthService;
use App\Http\Requests\Authunticate\LoginStore;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * ورود به حساب کاربری
     * @param LoginStore $request
     * @return JsonResponse
     */
    public function login(LoginStore $request)
    {
        $user =
            $this->authService->login(
                $request->only([
                    $this->authService->field() ,
                    "password"
                ]),
                $request->input("remember" , FALSE)
            );

        if ($user)
            return $this->success([
                "user"  => new UserResource($user = $this->authService->user()),
                "token" => $user->createToken("authunticate")->accessToken
            ]);

        return $this->error([
            "msg" => trans("dashboard.error.authunticate.login")
        ]);
    }

}

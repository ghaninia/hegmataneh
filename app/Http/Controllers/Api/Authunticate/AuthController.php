<?php

namespace App\Http\Controllers\Api\Authunticate;

use App\Core\Enums\EnumsUser;
use App\Core\Enums\EnumsOption;
use Illuminate\Http\JsonResponse;
use App\Services\User\UserService;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Services\Authunticate\AuthService;
use App\Http\Requests\Authunticate\LoginStore;
use App\Http\Requests\Authunticate\RegisterStore;

class AuthController extends Controller
{
    protected $authService, $userService;

    public function __construct(AuthService $authService, UserService $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;
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
                    $this->authService->field(),
                    "password"
                ]),
                $request->input("remember", FALSE)
            );

        if ($user)
            return $this->success([
                "user"  => new UserResource($user = $this->authService->user()),
                "token" => $user->createToken("authunticate")->accessToken
            ]);

        return $this->error([
            "msg" => trans("dashboard.error.authunticate.login")
        ], 404);
    }

    /**
     * ثبت حساب جدید
     * @param RegisterStore $request
     * @return JsonResponse
     */
    public function register(RegisterStore $request)
    {
        $user = $this->userService->create(
            array_merge($request->all(), [
                "status" => EnumsUser::STATUS_DISABLE,
                'role_id' => options(EnumsOption::DASHBOARD_REGISTER_RULE),
            ])
        );

        $this->userService->sendVerifyNotification($user);

        return $this->success([
            "msg" => trans("dashboard.success.register.create"),
            "data" => new UserResource($user)
        ]);
    }


    /**
     * تایید حساب کاربری
     * @param string $token
     * @return JsonResponse
     */
    public function verify(string $token)
    {
        if (!!$user = $this->userService->verify($token))
            $this->success([
                "msg" => trans("dashboard.success.register.verify"),
                "data" => $user
            ]);

        return $this->error([
            "msg" => trans("dashboard.error.register.verify"),
        ]);
    }
}

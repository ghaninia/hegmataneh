<?php

namespace App\Http\Controllers\Dashboard\Authunticate;

use App\Kernel\Enums\EnumsUser;
use App\Kernel\Enums\EnumsOption;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Services\User\UserServiceInterface;
use App\Http\Requests\Authunticate\LoginStore;
use App\Http\Requests\Authunticate\RegisterStore;
use App\Services\Authunticate\AuthServiceInterface;

class AuthController extends Controller
{
    public function __construct(
        protected AuthServiceInterface $authService,
        protected UserServiceInterface $userService
    ) {
    }

    /**
     * Login On system
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

        $user = $this->authService->user();

        if ($user)
            return $this->success([
            "msg" => trans("dashboard.success.authunticate.login" , [
                "attributes" => $user->name
            ]),
            "data"  => new UserResource($user->load(["role" , "files"])),
                "token" => $user->createToken("authunticate")->plainTextToken
            ]);

        return $this->error([
            "msg" => trans("dashboard.error.authunticate.login")
        ], 404);
    }

    /**
     * register On System
     * @param RegisterStore $request
     * @return JsonResponse
     */
    public function register(RegisterStore $request)
    {
        $user = $this->userService->updateOrCreate(
            array_merge($request->all(), [
                "status" => EnumsUser::STATUS_DISABLE,
                'role_id' => options(EnumsOption::DASHBOARD_DEFAULT_REGISTER_ROLE),
            ])
        );

        $this->userService->sendVerifyNotification($user);

        return $this->success([
            "msg" => trans("dashboard.success.register.create"),
            "data" => new UserResource($user)
        ]);

    }


    /**
     * Confirmed On system
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

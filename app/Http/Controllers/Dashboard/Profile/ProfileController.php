<?php

namespace App\Http\Controllers\Dashboard\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\ProfileUpdate;
use App\Http\Resources\User\UserResource;
use App\Services\Authunticate\AuthServiceInterface;
use App\Services\User\UserServiceInterface;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function __construct(
        protected AuthServiceInterface $authService ,
        protected UserServiceInterface $userService
    ){}

    /**
     * get current user profile
     * @return UserResource
     */
    public function index()
    {
        $user = $this->authService->user() ;

        return new UserResource(
            $user->load("files" , "role" , "currency" , "language")
        );

    }

    /**
     * edit auth user
     * @param ProfileUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProfileUpdate $request)
    {
        $user = $this->userService->updateOrCreate(
            $request->only([
                "language_id",
                "currency_id",
                "name",
                "email",
                "mobile",
                "username",
                "bio",
                "password",
            ]) ,
            $this->authService->user()
        );

        return $this->success([
            "data" => new UserResource(
                $user->load("files" , "role" , "currency" , "language")
            ) ,
            "msg" => trans("dashboard.success.profile.update")
        ]);
    }

}

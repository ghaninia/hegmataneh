<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserIndex;
use App\Http\Requests\User\UserStore;
use App\Http\Requests\User\UserUpdate;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserCollection;
use App\Services\User\UserServiceInterface;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller
{

    public function __construct(
        protected UserServiceInterface $userService
    ) {
    }

    /**
     * Display a listing of the resource
     * @param UserIndex $request
     * @return UserCollection
     */
    public function index(UserIndex $request)
    {
        $users = $this->userService->list(
            $request->only([
                "name",
                "username",
                "email",
                "mobile",
                "role_id",
                "status",
                "just_trashed"
            ])
        );

        return new UserCollection($users);
    }

    /**
     * Store a newly created resource in storage
     * @param UserStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserStore $request)
    {
        $user = $this->userService->updateOrCreate(
            $request->all()
        );

        return $this->success([
            "msg" => trans("dashboard.success.user.create"),
            "data" => new UserResource($user)
        ]);
    }

    /**
     * Display the specified resource
     * @param User $user
     * @return UserResource
     */
    public function show(User $user)
    {
        return
            new UserResource(
                $user->load([
                    "currency", "language", "role"
                ])
            );
    }

    /**
     * Update the specified resource in storage
     * @param UserUpdate $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserUpdate $request, User $user)
    {

        $user = $this->userService->updateOrCreate($request->all(), $user);

        return
            $this->success([
                "msg"  => trans("dashboard.success.user.update"),
                "data" => new UserResource($user->load(["currency", "language", "role"]))
            ]);
    }

    /**
     * Remove the specified resource from storage
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $this->userService->delete($user);

        return $this->success([
            "msg" => trans("dashboard.success.user.delete")
        ]);
    }
}

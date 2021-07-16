<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use App\Http\Requests\UserUpdate;
use App\Services\User\UserService;
use App\Services\View\ViewService;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserIndex;
use App\Http\Requests\User\UserStore;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserCollection;

class UserController extends Controller
{

    protected $userService , $viewService ;
    public function __construct(UserService $userService , ViewService $viewService)
    {
        $this->userService = $userService;
        $this->viewService = $viewService ;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserIndex $request)
    {
        $users = $this->userService->list(
            $request->only([
                "name", "username", "email", "mobile", "role"
            ])
        );

        return new UserCollection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStore $request)
    {
        $user = $this->userService->create(
            $request->all()
        );

        return $this->success([
            "msg" => trans("dashboard.success.user.create"),
            "data" => new UserResource($user)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return JsonResource
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserUpdate  $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdate $request, User $user)
    {
        $user = $this->userService->update($user, $request->all());

        return $this->success([
            "msg"  => trans("dashboard.success.user.update"),
            "data" => new UserResource($user)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->userService->delete($user);
        return $this->success([
            "msg" => trans("dashboard.success.user.delete")
        ]);
    }
}

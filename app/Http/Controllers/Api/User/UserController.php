<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use App\Http\Requests\UserUpdate;
use App\Services\Post\PostService;
use App\Services\User\UserService;
use App\Services\View\ViewService;
use App\Services\Vote\VoteService;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Detail\DetailUserPostStore;
use App\Http\Requests\User\UserIndex;
use App\Http\Requests\User\UserStore;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\Post\PostCollection;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\View\ViewCollection;
use App\Http\Resources\Vote\VoteCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Requests\User\Details\DetailUserViewStore;
use App\Http\Requests\User\Details\DetailUserVoteStore;

class UserController extends Controller
{

    protected
        $userService,
        $viewService,
        $voteService,
        $postService;

    public function __construct(
        UserService $userService,
        ViewService $viewService,
        VoteService $voteService,
        PostService $postService
    ) {
        $this->userService = $userService;
        $this->viewService = $viewService;
        $this->voteService = $voteService;
        $this->postService = $postService;
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

    /**
     * Get all user views
     *
     * @param User $user
     * @param DetailUserViewStore $request
     * @return JsonResource
     */
    public function views(User $user, DetailUserViewStore $request): JsonResource
    {
        $request->merge(["user" => $user->id]);

        return new ViewCollection(
            $this->viewService->list(
                $filters = $request->only([
                    "user", "user_ip"
                ])
            )
        );
    }

    /**
     * Get all user votes
     *
     * @param User $user
     * @param DetailUserVoteStore $request
     * @return JsonResource
     */
    public function votes(User $user, DetailUserVoteStore $request): JsonResource
    {

        $request->merge(["user" => $user->id]);

        return new VoteCollection(
            $this->voteService->list(
                $filters = $request->only([
                    "user", "user_ip", "post_id"
                ])
            )
        );
    }

    /**
     * Get all user posts
     *
     * @param User $user
     * @param DetailUserVoteStore $request
     * @return JsonResource
     */
    public function posts(User $user, DetailUserPostStore $request): JsonResource
    {

        $request->merge(["user" => $user->id]);

        return new PostCollection(
            $this->postService->list(
                $filters = $request->only([
                    "user",
                    "status" ,
                    "comment_status" ,
                    "vote_status" ,
                    "format" ,
                    "slug" ,
                    "title" ,
                    "content" ,
                ])
            )
        );
    }
}

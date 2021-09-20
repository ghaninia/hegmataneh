<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use App\Services\Page\PageService;
use App\Services\Post\PostService;
use App\Services\User\UserService;
use App\Services\View\ViewService;
use App\Services\Vote\VoteService;
use App\Http\Controllers\Controller;
use App\Services\Skill\SkillService;
use App\Http\Requests\User\UserIndex;
use App\Http\Requests\User\UserStore;
use App\Http\Requests\User\UserUpdate;
use App\Services\Comment\CommentService;
use App\Services\Product\ProductService;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\Page\PageCollection;
use App\Http\Resources\Post\PostCollection;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\View\ViewCollection;
use App\Http\Resources\Vote\VoteCollection;
use App\Services\Portfolio\PortfolioService;
use App\Http\Resources\Skill\SkillCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Comment\CommentCollection;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Portfolio\PortfolioCollection;
use App\Http\Requests\User\Detail\DetailUserPageStore;
use App\Http\Requests\User\Detail\DetailUserPostStore;
use App\Http\Requests\User\Detail\DetailUserViewStore;
use App\Http\Requests\User\Detail\DetailUserVoteStore;
use App\Http\Requests\User\Detail\DetailUserSkillStore;
use App\Http\Requests\User\Detail\DetailUserCommentStore;
use App\Http\Requests\User\Detail\DetailUserProductStore;
use App\Http\Requests\User\Detail\DetailUserPortfolioStore;

class UserController extends Controller
{

    protected
        $userService,
        $viewService,
        $voteService,
        $postService,
        $productService,
        $pageService,
        $skillService,
        $portfolioService ,
        $commentService;

    public function __construct(
        UserService $userService,
        ViewService $viewService,
        VoteService $voteService,
        PostService $postService,
        ProductService $productService,
        PageService $pageService,
        SkillService $skillService,
        PortfolioService $portfolioService ,
        CommentService $commentService
    ) {
        $this->userService = $userService;
        $this->viewService = $viewService;
        $this->voteService = $voteService;
        $this->postService = $postService;
        $this->productService = $productService;
        $this->pageService = $pageService;
        $this->skillService = $skillService;
        $this->portfolioService = $portfolioService ;
        $this->commentService = $commentService ;
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

        return
            $this->success([
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

        $filters = array_merge(
            ["user" => $user->id],
            $request->only([
                "user", "user_ip"
            ])
        );

        return new ViewCollection(
            $this->viewService->list($filters)
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

        $filters = array_merge(
            ["user" => $user->id],
            $request->only([
                "user", "user_ip", "post_id"
            ])
        );

        return new VoteCollection(
            $this->voteService->list($filters)
        );
    }

    /**
     * Get all user posts
     *
     * @param User $user
     * @param DetailUserPostStore $request
     * @return JsonResource
     */
    public function posts(User $user, DetailUserPostStore $request): JsonResource
    {
        $filters = array_merge(
            ["user" => $user->id],
            $request->only([
                "user",
                "status",
                "comment_status",
                "vote_status",
                "format",
                "slug",
                "title",
                "content",
                "created_at" ,
            ])
        );

        return new PostCollection(
            $this->postService->list($filters)
        );
    }

    /**
     * Get all user products
     *
     * @param User $user
     * @param DetailUserProductStore $request
     * @return JsonResource
     */
    public function products(User $user, DetailUserProductStore $request): JsonResource
    {
        $filters = array_merge(
            ["user" => $user->id],
            $request->only([
                "user",
                "status",
                "comment_status",
                "vote_status",
                "format",
                "slug",
                "title",
                "content",
                "development",
                "price"
            ])
        );
        return new ProductCollection(
            $this->productService->list($filters)
        );
    }

    /**
     * Get all user pages
     *
     * @param User $user
     * @param DetailUserPageStore $request
     * @return JsonResource
     */
    public function pages(User $user, DetailUserPageStore $request): JsonResource
    {
        $filters = array_merge(
            ["user" => $user->id],
            $request->only([
                "user",
                "status",
                "comment_status",
                "vote_status",
                "format",
                "slug",
                "title",
                "content",
                "theme"
            ])
        );
        return new PageCollection(
            $this->pageService->list($filters)
        );
    }

    /**
     * Get all user skills
     *
     * @param User $user
     * @param DetailUserSkillStore $request
     * @return JsonResource
     */
    public function skills(User $user, DetailUserSkillStore $request): JsonResource
    {
        $filters = array_merge(
            ["user" => $user->id],
            $request->only([
                "title_fa",
                "title_en",
            ])
        );
        return new SkillCollection(
            $this->skillService->list($filters)
        );
    }

    /**
     * Get all user portfolios
     *
     * @param User $user
     * @param DetailUserPortfolioStore $request
     * @return JsonResource
     */
    public function portfolios(User $user, DetailUserPortfolioStore $request): JsonResource
    {
        $filters = array_merge(
            ["user" => $user->id],
            $request->only([
                "name",
                "description",
                "demo",
                "excerpt",
                "percent",
                "launched_at"
            ])
        );

        return new PortfolioCollection(
            $this->portfolioService->list($filters)
        );
    }

    /**
     * Get all user comments
     *
     * @param User $user
     * @param DetailUserCommentStore $request
     * @return JsonResource
     */
    public function comments(User $user, DetailUserCommentStore $request): JsonResource
    {
        $filters = array_merge(
            ["user" => $user->id],
            $request->only([
                'comment_id',
                'post_id',
                'fullname',
                'email',
                'website',
                'ipv4',
                'status',
                'content',
                "created_at"
            ])
        );

        return new CommentCollection(
            $this->commentService->list($filters)
        );
    }

}

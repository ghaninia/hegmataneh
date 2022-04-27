<?php

namespace App\Http\Controllers\Dashboard\Post;

use App\Models\Post;
use App\Models\User;
use App\Services\Tag\TagService;
use App\Services\Post\PostService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostIndex;
use App\Http\Requests\Post\PostStore;
use App\Http\Requests\Post\PostUpdate;
use App\Http\Resources\Post\PostResource;
use App\Services\Category\CategoryService;
use App\Http\Resources\Post\PostCollection;

class PostController extends Controller
{

    public function __construct(
        protected PostService $postService,
        protected CategoryService $categoryService,
        protected TagService $tagService
    ) {
    }

    /**
     * Display a listing of the resource
     * @param User $user
     * @param PostIndex $request
     * @return PostCollection
     */
    public function index(User $user, PostIndex $request)
    {
        $filters = array_merge(
            ["user" => $user->id],
            $request->only([
                "comment_status",
                "vote_status",
                "status",
                "format",
                "slug",
                "title",
                "content",
                "created_at",
                "published_at"
            ])
        );
        $posts = $this->postService->list($filters);
        return new PostCollection(
            $posts->loadCount(["views", "comments", "votes"])
        );
    }

    /**
     * Store a newly created resource in storage
     * @param User $user
     * @param PostStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(User $user, PostStore $request)
    {
        $post =
            $this->postService->updateOrCreate(
                $user,
                $request->all()
            );

        return $this->success([
            "data" => new PostResource($post),
            "msg"  => trans("dashboard.success.post.create")
        ]);
    }

    /**
     * Display the specified resource
     * @param User $user
     * @param Post $post
     * @return PostResource
     */
    public function show(User $user, Post $post)
    {
        return new PostResource(
            $post
                ->load("categories", "tags", "user")
                ->loadCount(["views", "comments", "votes"])
        );
    }

    /**
     * Update the specified resource in storage
     * @param User $user
     * @param Post $post
     * @param PostUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(User $user, Post $post, PostUpdate $request)
    {

        $post =
            $this->postService->updateOrCreate(
                $user,
                $request->all(),
                $post
            );

        return $this->success([
            "data" => new PostResource($post),
            "msg"  => trans("dashboard.success.post.update")
        ]);
    }

    /**
     * Remove the specified resource from storage
     * @param User $user
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user, Post $post)
    {
        $this->postService->delete($post);

        return $this->success([
            "msg" => trans("dashboard.success.post.delete")
        ]);
    }

    /**
     * restore single post
     * @param User $user
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(User $user, Post $post)
    {
        $this->postService->restore($post);
        return $this->success([
            "msg" => trans("dashboard.success.post.restore")
        ]);
    }

    /**
     * force delete single post
     * @param User $user
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function forceDelete(User $user, Post $post)
    {
        $this->postService->forceDelete($post);
        return $this->success([
            "msg" => trans("dashboard.success.post.forceDelete")
        ]);
    }
}

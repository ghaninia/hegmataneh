<?php

namespace App\Http\Controllers\Api\Post;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Post\PostService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostIndex;
use App\Http\Requests\Post\PostStore;
use App\Http\Requests\Post\Page\PageStore;
use App\Http\Resources\Post\PostCollection;

class PostController extends Controller
{
    protected $postService;
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, PostStore $request)
    {
        $post =
            $this->postService->create(
                $user,
                $request->all()
            );
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

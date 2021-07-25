<?php

namespace App\Http\Controllers\Api\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Page\PageService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Page\PageResource;
use App\Http\Requests\Post\Page\PageStore;

class PageController extends Controller
{
    protected $pageService;
    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $this->authorizeForUser($user, 'viewAny', Post::class);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, PageStore $request)
    {
        $this->authorizeForUser($user, 'create', Post::class);

        $page = $this->pageService->create(
            $user,
            $request->only([
                "status",
                "comment_status",
                "vote_status",
                "format",
                "development",
                "title",
                "slug",
                "content",
                "excerpt",
                "faq",
                "theme",
                "published_at",
                "created_at",
            ])
        );

        return $this->success([
            "data" => new PageResource($page),
            "msg"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user,  Post $page)
    {
        $this->authorizeForUser($user, 'view', $page);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, Post $page, Request $request)
    {
        $this->authorizeForUser($user, 'update', $page);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Post $page)
    {
        $this->authorizeForUser($user, 'delete', $page);
    }
}

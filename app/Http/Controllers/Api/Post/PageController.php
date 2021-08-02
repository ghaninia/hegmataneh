<?php

namespace App\Http\Controllers\Api\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Page\PageService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Page\PageResource;
use App\Http\Requests\Post\Page\PageIndex;
use App\Http\Requests\Post\Page\PageStore;
use App\Http\Requests\Post\Page\PageUpdate;
use App\Http\Resources\Page\PageCollection;

class PageController extends Controller
{
    protected $pageService;
    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    /**
     * Display a listing of the resource.
     * @param  User $user
     * @param  PageIndex $request
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, PageIndex $request)
    {
        $filters = array_merge(
            [
                "user" => $user->id,
            ],
            $request->only([
                "comment_status",
                "vote_status",
                "status",
                "format",
                "slug",
                "title",
                "content",
                "development",
                "theme",
            ])
        );
        $pages =
            $this->pageService
            ->list($filters)
            ->loadCount([
                "views",
                "comments",
                "votes"
            ]);
        return new PageCollection($pages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  User $user
     * @param  PageStore $request
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, PageStore $request)
    {
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
            "msg" => trans("dashboard.success.page.create")
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @param  Post $page
     * @return \Illuminate\Http\Response
     */
    public function show(User $user,  Post $page)
    {
        return new PageResource($page->loadCount([
            "views",
            "comments",
            "votes"
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, Post $page, PageUpdate $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Post $page)
    {
    }
}

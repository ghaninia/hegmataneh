<?php

namespace App\Services\Page;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Kernel\Enums\EnumsPost;
use App\Kernel\Enums\EnumsFileable;
use App\Services\Slug\SlugService;
use App\Services\Translation\TranslationService;

class PageService implements PageServiceInterface
{

    public function __construct(
        protected TranslationService $translationService,
        protected SlugService $slugService
    ) {
    }

    /**
     * get list poges
     * @param array $filters
     * @return mixed
     */
    public function list(array $filters)
    {
        return
            Post::query()
            ->where("type", EnumsPost::TYPE_PAGE)
            ->filterBy($filters)
            ->paginate();
    }

    /**
     * create or update page
     * @param User $user
     * @param array $data
     * @param Post|null $page
     * @return Post
     */
    public function updateOrCreate(User $user, array $data, ?Post $page = null): Post
    {
        $page = Post::updateOrCreate([
            "id" => $page->id ?? null
        ], [
            "type" => EnumsPost::TYPE_PAGE,
            "status" => $data["status"],
            "user_id" => $user->id,
            "comment_status" => $data["comment_status"] ?? false,
            "vote_status" => $data["vote_status"] ?? false,
            "format" => $data["format"] ?? EnumsPost::FORMAT_CONTEXT,
            "development" => $data["development"] ?? 0,
            "theme" => $data["theme"] ?? NULL,
            "published_at" => $data["published_at"] ?? NULL,
            "created_at" => $page->created_at ?? $data["created_at"] ?? Carbon::now()
        ]);

        $this->translationService->sync($page, $translations = $data["translations"]);

        $this->slugService->sync($page, $translations);

        return $page->load(["translations", "slugs", "files"]);
    }

    /**
     * delete page
     * @param Post $page
     * @return mixed
     */
    public function delete(Post $page)
    {
        return Post::whereId($page->id)->forceDelete();
    }
}

<?php

namespace App\Services\Page;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Core\Enums\EnumsPost;
use App\Services\Slug\SlugService;
use App\Repositories\Post\PostRepository;
use App\Services\Translation\TranslationService;

class PageService implements PageServiceInterface
{
    protected
        $postRepo,
        $translationService,
        $slugService;

    public function __construct(
        PostRepository $postRepo,
        TranslationService $translationService,
        SlugService $slugService
    ) {
        $this->postRepo = $postRepo;
        $this->slugService = $slugService;
        $this->translationService = $translationService;
    }

    /**
     * لیست تمام برگه ها
     * @param array $filters
     * @return Paginator
     */
    public function list(array $filters)
    {
        return
            $this->postRepo->query()
            ->where("type", EnumsPost::TYPE_PAGE)
            ->filterBy($filters)
            ->with(["translations", "slugs"])
            ->paginate();
    }

    /**
     * ساخت برگه جدید
     * @param User $user
     * @param array $data
     * @param Post $post | null
     * @return Post
     */
    public function updateOrCreate(User $user, array $data, ?Post $page = null): Post
    {
        $page = $this->postRepo
            ->updateOrCreate([
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

        return $page->load(["translations", "slugs"]);
    }

    /**
     * حذف برگه
     * @param Post $page
     * @return boolean
     */
    public function delete(Post $page): bool
    {
        return $this->postRepo->forceDelete($page);
    }
}

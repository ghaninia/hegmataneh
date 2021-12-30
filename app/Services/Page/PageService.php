<?php

namespace App\Services\Page;

use App\Core\Enums\EnumsFileable;
use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Core\Enums\EnumsPost;
use App\Services\Slug\SlugService;
use App\Repositories\Post\PostRepository;
use App\Services\File\FileService;
use App\Services\Translation\TranslationService;

class PageService implements PageServiceInterface
{

    public function __construct(
        protected PostRepository $postRepo,
        protected TranslationService $translationService,
        protected SlugService $slugService,
        protected FileService $fileService
    ) {
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

        ### تصویر شاخص
        $this->fileService->sync($page, EnumsFileable::USAGE_THUMBNAIL,  $data["thumbnail"] ?? NULL);
        ### تصویر کاور
        $this->fileService->sync($page, EnumsFileable::USAGE_COVER ,  $data["cover"] ?? NULL);

        return $page->load(["translations", "slugs", "files"]);
    }

    /**
     * حذف برگه
     * @param Post $page
     * @return boolean
     */
    public function delete(Post $page)
    {
        return $this->postRepo->forceDelete($page);
    }
}

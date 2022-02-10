<?php

namespace App\Services\Post;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Core\Enums\EnumsPost;
use App\Jobs\PublishedPostJob;
use App\Services\Tag\TagService;
use App\Services\Slug\SlugService;
use App\Services\Category\CategoryService;
use App\Services\Post\PostServiceInterface;
use App\Services\Translation\TranslationService;

class PostService implements PostServiceInterface
{

    protected
        $translationService,
        $categoryService,
        $slugService,
        $tagService;

    public function __construct(
        TranslationService $translationService,
        CategoryService $categoryService,
        SlugService $slugService,
        TagService $tagService
    ) {
        $this->translationService = $translationService;
        $this->categoryService = $categoryService;
        $this->slugService = $slugService;
        $this->tagService = $tagService;
    }

    /**
     * لیست تمام پست ها
     * @param array $filters
     * @return Paginator
     */
    public function list(array $filters)
    {
        return
            Post::query()
            ->where("type", EnumsPost::TYPE_POST)
            ->filterBy($filters)
            ->with(["translations", "slugs"])
            ->paginate();
    }

    /**
     * پابلیک کردن پست
     * @param Post $post
     * @return void
     */
    public function published(Post $post): void
    {
        $post->update([
            "status" => EnumsPost::STATUS_PUBLISHED
        ]);
    }

    /**
     * فراخوانی جاب جهت پابلیش کردن پست
     * @param Post $post
     * @return void
     */
    public function setPublishedJob(Post $post): void
    {
        PublishedPostJob::dispatch($post)->delay(
            $post->published_at
        );
    }

    /**
     * ثبت پست جدید
     * @param User $user
     * @param array $data
     * @param Post $post|null
     */
    public function updateOrCreate(User $user, array $data, ?Post $post = null): Post
    {
        $post =
            Post::updateOrCreate([
                "id" => $post->id ?? null
            ], [
                "user_id" => $user->id,
                "type" => EnumsPost::TYPE_POST,
                "status" => $data["status"],
                "comment_status" => $data["comment_status"] ?? false,
                "vote_status" => $data["vote_status"] ?? false,
                "format" => $data["format"] ?? EnumsPost::FORMAT_CONTEXT,
                "published_at" => $data["published_at"] ?? NULL,
                "created_at" => $post->created_at ?? $data["created_at"] ?? Carbon::now()
            ]);

        $this->translationService->sync($post, $translations = $data["translations"] ?? []);
        $this->slugService->sync($post, $translations);

        $this->tagService->sync(
            $post,
            $data["tags"] ?? []
        );

        $this->categoryService->sync(
            $post,
            $data["categories"] ?? []
        );

        return $post->load(["translations", "slugs", "categories", "tags"]);
    }

    /**
     * حذف پست
     * @param Post $post
     * @return boolean
     */
    public function delete(Post $post)
    {
        return $post->delete();
    }

    /**
     * رستور کردن پست حذف شده
     * @param Post $post
     * @return boolean
     */
    public function restore(Post $post)
    {
        return $post->restore();
    }

    /**
     * حذف اجباری پست
     * @param Post $post
     */
    public function forceDelete(Post $post)
    {
        return $post->forceDelete();
    }
}

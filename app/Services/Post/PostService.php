<?php

namespace App\Services\Post;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Kernel\Enums\EnumsPost;
use App\Jobs\PublishedPostJob;
use App\Services\Tag\TagService;
use App\Services\Slug\SlugService;
use App\Services\Category\CategoryService;
use App\Services\Translation\TranslationService;

class PostService implements PostServiceInterface
{

    /**
     * @param TranslationService $translationService
     * @param CategoryService $categoryService
     * @param SlugService $slugService
     * @param TagService $tagService
     */
    public function __construct(
        protected TranslationService $translationService,
        protected CategoryService $categoryService,
        protected SlugService $slugService,
        protected TagService $tagService
    ) {
    }

    /**
     * list posts
     * @param array $filters
     * @return mixed
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
     * post to publish
     * @param Post $post
     */
    public function published(Post $post): void
    {
        $post->update([
            "status" => EnumsPost::STATUS_PUBLISHED
        ]);
    }

    /**
     * Publish the post queue
     * @param Post $post
     */
    public function setPublishedJob(Post $post): void
    {
        PublishedPostJob::dispatch($post)->delay(
            $post->published_at
        );
    }

    /**
     * create or update posts
     *
     * @param User $user
     * @param array $data
     * @param Post|null $post
     * @return Post
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
     * delete post
     * @param Post $post
     * @return bool|null
     */
    public function delete(Post $post)
    {
        return $post->delete();
    }

    /**
     * restore post
     * @param Post $post
     * @return bool|null
     */
    public function restore(Post $post)
    {
        return $post->restore();
    }

    /**
     * force delete post
     * @param Post $post
     * @return bool|null
     */
    public function forceDelete(Post $post)
    {
        return $post->forceDelete();
    }
}

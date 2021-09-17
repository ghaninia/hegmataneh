<?php

namespace App\Services\Post;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Core\Enums\EnumsPost;
use App\Jobs\PublishedPostJob;
use App\Repositories\Post\PostRepository;
use App\Services\Post\PostServiceInterface;

class PostService implements PostServiceInterface
{
    protected $postRepo;

    public function __construct(PostRepository $postRepo)
    {
        $this->postRepo = $postRepo;
    }

    /**
     * لیست تمام پست ها
     * @param array $filters
     * @return Paginator
     */
    public function list(array $filters)
    {
        return
            $this->postRepo->query()
            ->where("type", EnumsPost::TYPE_POST)
            ->filterBy($filters)
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
        return
            $this->postRepo->updateOrCreate([
                "id" => $post->id ?? null
            ], [
                "user_id" => $user->id,
                "title" => $data["title"],
                "slug" => slug($data["slug"] ?? NULL, $data["title"]),
                "content" => $data["content"] ?? NULL,
                "faq" => $data["faq"] ?? NULL,
                "excerpt" => $data["excerpt"] ?? NULL,
                "type" => EnumsPost::TYPE_POST,
                "status" => $data["status"],
                "comment_status" => $data["comment_status"] ?? false,
                "vote_status" => $data["vote_status"] ?? false,
                "format" => $data["format"] ?? EnumsPost::FORMAT_CONTEXT,
                "goal_post" => $data["goal_post"] ?? NULL,
                "published_at" => $data["published_at"] ?? NULL,
                "created_at" => $post->created_at ?? $data["created_at"] ?? Carbon::now()
            ]);
    }

    /**
     * حذف پست
     * @param Post $post
     * @return boolean
     */
    public function delete(Post $post)
    {
        return $this->postRepo->delete($post);
    }

    /**
     * رستور کردن پست حذف شده
     * @param Post $post
     * @return boolean
     */
    public function restore(Post $post)
    {
        return $this->postRepo->restore($post);
    }

    /**
     * حذف اجباری پست
     * @param Post $post
     * @return void
     */
    public function forceDelete(Post $post): void
    {
        $this->postRepo->forceDelete($post);
    }
}

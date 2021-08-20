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
            Carbon::parse($post->published_at)
        );
    }

    /**
     * ثبت پست جدید
     * @param User $user
     * @param array $data
     */
    public function create(User $user, array $data): Post
    {
        return
            $this->postRepo->create([
                "type" => EnumsPost::TYPE_PAGE,
                "status" => $data["status"],
                "user_id" => $user->id,
                "comment_status" => $data["comment_status"] ?? false,
                "vote_status" => $data["vote_status"] ?? false,
                "format" => $data["format"] ?? EnumsPost::FORMAT_CONTEXT,
                "development" => $data["development"] ?? 0,
                "title" => $data["title"],
                "goal_post" => $data["goal_post"] ?? NULL,
                "slug" => slug($data["slug"] ?? NULL, $data["title"]),
                "content" => $data["content"] ?? NULL,
                "faq" => $data["faq"] ?? NULL,
                "excerpt" => $data["excerpt"] ?? NULL,
                "published_at" => $data["published_at"] ?? NULL,
                "created_at" => $data["created_at"] ?? Carbon::now()
            ]);
    }
}

<?php

namespace App\Services\Post;

use Carbon\Carbon;
use App\Models\Post;
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
}

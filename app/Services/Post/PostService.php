<?php

namespace App\Services\Post;

use App\Core\Enums\EnumsPost;
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
     * لیست تمام کاربران
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
}

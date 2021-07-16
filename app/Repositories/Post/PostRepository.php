<?php

namespace App\Repositories\Post;

use App\Models\Post;
use App\Repositories\Post\PostRepositoryInterface;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Post::class;
    }

    public function query()
    {
        return $this->model;
    }
}

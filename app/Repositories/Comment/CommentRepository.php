<?php

namespace App\Repositories\Comment;

use App\Models\Comment;
use App\Repositories\Comment\CommentRepositoryInterface;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Comment::class ;
    }

    public function query()
    {
        return $this->model ;
    }
}

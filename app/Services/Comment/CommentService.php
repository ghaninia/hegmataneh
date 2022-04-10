<?php

namespace App\Services\Comment;

use App\Models\Comment;
use App\Services\Comment\CommentServiceInterface;

class CommentService implements CommentServiceInterface
{

    /**
     * get comments list
     * @param array $filters
     * @return mixed
     */
    public function list(array $filters)
    {
        return
            Comment::query()
            ->filterBy($filters)
            ->paginate();
    }
}

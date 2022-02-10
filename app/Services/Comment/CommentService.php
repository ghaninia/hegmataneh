<?php

namespace App\Services\Comment;

use App\Models\Comment;
use App\Services\Comment\CommentServiceInterface;

class CommentService implements CommentServiceInterface
{

    /**
     * لیست تمام کامنت ها
     * @param array $filters
     * @return Paginator
     */
    public function list(array $filters)
    {
        return
            Comment::query()
            ->filterBy($filters)
            ->paginate();
    }
}

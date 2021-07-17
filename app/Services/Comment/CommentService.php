<?php

namespace App\Services\Comment;

use App\Repositories\Comment\CommentRepository;
use App\Services\Comment\CommentServiceInterface;

class CommentService implements CommentServiceInterface
{
    protected $commentRepo;
    public function __construct(CommentRepository $commentRepo)
    {
        $this->commentRepo = $commentRepo;
    }

    /**
     * لیست تمام کامنت ها
     * @param array $filters
     * @return Paginator
     */
    public function list(array $filters)
    {
        return
            $this->commentRepo->query()
            ->filterBy($filters)
            ->paginate();
    }
}

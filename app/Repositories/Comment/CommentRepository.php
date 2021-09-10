<?php

namespace App\Repositories\Comment;

use App\Models\Comment;
use App\Repositories\Comment\CommentRepositoryInterface;
use App\Core\Traits\ExteraQueriesTrait;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    use ExteraQueriesTrait ;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Comment::class ;
    }

}

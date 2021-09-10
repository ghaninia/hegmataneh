<?php

namespace App\Repositories\Post;

use App\Models\Post;
use App\Repositories\Post\PostRepositoryInterface;
use App\Core\Traits\ExteraQueriesTrait;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    use ExteraQueriesTrait ;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Post::class;
    }
}

<?php

namespace App\Repositories\Post;

use App\Models\Post;
use App\Core\Traits\OtherBaseRepository;
use App\Repositories\Post\PostRepositoryInterface;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    use OtherBaseRepository ;

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

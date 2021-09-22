<?php

namespace App\Repositories\Slug;

use App\Models\Slug;
use App\Repositories\Slug\SlugRepositoryInterface;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

class SlugRepository extends BaseRepository implements SlugRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Slug::class ;
    }
}

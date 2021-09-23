<?php

namespace App\Repositories\Slug;

use App\Models\Slug;
use App\Core\Traits\ExteraQueriesTrait;
use App\Repositories\Slug\SlugRepositoryInterface;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

class SlugRepository extends BaseRepository implements SlugRepositoryInterface
{
    use ExteraQueriesTrait ;
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

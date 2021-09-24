<?php

namespace App\Repositories\Episode;

use App\Models\Episode;
use App\Core\Traits\ExteraQueriesTrait;
use App\Repositories\Episode\EpisodeRepositoryInterface;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

class EpisodeRepository extends BaseRepository implements EpisodeRepositoryInterface
{
    use ExteraQueriesTrait; 
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Episode::class;
    }
}

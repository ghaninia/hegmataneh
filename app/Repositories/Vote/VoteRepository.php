<?php

namespace App\Repositories\Vote;

use App\Models\Vote;
use App\Repositories\Vote\VoteRepositoryInterface;
use App\Core\Traits\ExteraQueriesTrait;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

class VoteRepository extends BaseRepository implements VoteRepositoryInterface
{
    use ExteraQueriesTrait ;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Vote::class;
    }
}

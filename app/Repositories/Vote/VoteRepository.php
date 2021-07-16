<?php

namespace App\Repositories\Vote;

use App\Models\Vote;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;
use App\Repositories\Vote\VoteRepositoryInterface;

class VoteRepository extends BaseRepository implements VoteRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Vote::class;
    }

    public function query()
    {
        return $this->model;
    }
}

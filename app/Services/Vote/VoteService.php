<?php

namespace App\Services\Vote;

use App\Repositories\Vote\VoteRepository;
use App\Services\Vote\VoteServiceInterface;

class VoteService implements VoteServiceInterface
{
    protected $voteRepo;

    public function __construct(VoteRepository $voteRepo)
    {
        $this->voteRepo = $voteRepo;
    }

    public function list(array $filters)
    {
        return
            $this->voteRepo->query()
            ->filterBy($filters)
            ->paginate();
    }
}

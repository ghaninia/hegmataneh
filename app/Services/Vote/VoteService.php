<?php

namespace App\Services\Vote;

use App\Kernel\Vote\Interfaces\VoteableInterface;
use App\Models\User;
use App\Models\Vote;

class VoteService implements VoteServiceInterface
{

    /**
     * get votes list
     * @param array $filters
     * @return mixed
     */
    public function list(array $filters)
    {
        return
            Vote::query()
            ->filterBy($filters)
            ->paginate();
    }

    /**
     * create new vote for voteable model
     * @param VoteableInterface $voteable
     * @param string $ipv4
     * @param int $vote
     * @param User|null $user
     */
    public function create(
        VoteableInterface $voteable,
        string $ipv4,
        int $vote,
        User $user = null
    ): void {
        Vote::query()
            ->updateOrCreate([
                "voteable_id" => $voteable->viewable_id,
                "voteable_type" => $voteable->viewable_type,
                "user_id" => optional($user)->id,
                "ipv4" => $ipv4
            ], [
                "vote" => $vote
            ]);
    }
}

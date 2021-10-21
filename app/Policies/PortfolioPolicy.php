<?php

namespace App\Policies;

use App\Models\Portfolio;
use App\Models\User;
use App\Models\Serial;
use Illuminate\Auth\Access\HandlesAuthorization;

class PortfolioPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view(...$arguments)
    {
        return $this->allow(...$arguments);
    }
    public function update(...$arguments)
    {
        return $this->allow(...$arguments);
    }
    public function delete(...$arguments)
    {
        return $this->allow(...$arguments);
    }

    public function allow(User $user, Portfolio $portfolio)
    {
        return $user->id === $portfolio->user_id;
    }
}

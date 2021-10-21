<?php

namespace App\Policies;

use App\Models\Serial;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SerialPolicy
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

    public function allow(User $user, Serial $serial)
    {
        return $user->id === $serial->user_id;
    }
}

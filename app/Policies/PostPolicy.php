<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
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

    public function allow(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }
}

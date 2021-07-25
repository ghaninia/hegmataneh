<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
    }

    public function viewAny()
    {
        return true ;
    }

    public function create(User $user)
    {
        return true ;
    }

    public function view(User $user, Post $post)
    {
        return $post->user_id === $user->id ;
    }

    public function update(User $user, Post $post)
    {
        return $post->user_id === $user->id ;
    }

    public function delete(User $user, Post $post)
    {
        return $post->user_id === $user->id ;
    }

}

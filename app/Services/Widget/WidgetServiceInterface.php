<?php

namespace App\Services\Widget;

use App\Models\User;
use Illuminate\Support\Collection;

interface WidgetServiceInterface
{
    public function setUser(User $user) ;
    public function statisticPosts(): Collection ;
}

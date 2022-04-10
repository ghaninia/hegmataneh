<?php

namespace App\Services\View;

use App\Kernel\View\Interfaces\ViewableInterface;
use App\Models\User;
use App\Models\View;

class ViewService implements ViewServiceInterface
{

    /**
     * get all views
     * @param array $filters
     * @return mixed
     */
    public function list(array $filters)
    {
        return
            View::query()
            ->filterBy($filters)
            ->paginate();
    }

    /**
     * create new view for viewable model
     * @param ViewableInterface $viewable
     * @param string $ipv4
     * @param User|null $user
     */
    public function create(ViewableInterface $viewable, string $ipv4, User $user = null): void
    {
        View::firstOrCreate([
            "viewable_id" => $viewable->viewable_id,
            "viewable_type" => $viewable->viewable_type,
            "ipv4" => $ipv4,
            "user_id" => optional($user)->id
        ]);
    }
}

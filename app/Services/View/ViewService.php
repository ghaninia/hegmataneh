<?php

namespace App\Services\View;

use App\Models\User;
use App\Repositories\View\ViewRepository;
use App\Core\Interfaces\ViewableInterface;
use App\Services\View\ViewServiceInterface;

class ViewService implements ViewServiceInterface
{
    protected $viewRepo;

    public function __construct(ViewRepository $viewRepo)
    {
        $this->viewRepo = $viewRepo;
    }

    /**
     * لیست تمام امتیازها
     * @param array $filters
     * @return Paginator
     */
    public function list(array $filters)
    {
        return
            $this->viewRepo->query()
            ->filterBy($filters)
            ->paginate();
    }

    /**
     * ساخت یک لاگ نمایش جدید
     * @param ViewableInterface $viewable
     * @param string $ipv4
     * @param User|null $user
     */
    public function create(ViewableInterface $viewable, string $ipv4, User $user = null): void
    {
        $this->viewRepo->query()
            ->firstOrCreate([
                "viewable_id" => $viewable->viewable_id,
                "viewable_type" => $viewable->viewable_type,
                "ipv4" => $ipv4,
                "user_id" => optional($user)->id
            ]);
    }
}

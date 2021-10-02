<?php

namespace App\Services\Widget;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Repositories\Post\PostRepository;
use App\Repositories\Role\RoleRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\View\ViewRepository;
use App\Services\Widget\WidgetServiceInterface;

class WidgetService implements WidgetServiceInterface
{
    protected $postRepo, $userRepo, $roleRepo, $viewRepo;
    private $user;

    public function __construct(
        PostRepository $postRepo,
        UserRepository $userRepo,
        RoleRepository $roleRepo,
        ViewRepository $viewRepo
    ) {
        $this->postRepo = $postRepo;
        $this->userRepo = $userRepo;
        $this->roleRepo = $roleRepo;
        $this->viewRepo = $viewRepo;
    }

    /**
     * @param User $user 
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * دریافت تمام فعالیت های در جدول مدل کاربر
     */
    public function statisticPosts(): Collection
    {

        return $this->postRepo->query()
            ->select([
                DB::raw("COUNT(*) AS count"),
                "status",
                "type"
            ])
            ->when($this->user, function ($query) {
                $query->where("user_id", $this->user->id);
            })
            ->groupBy([
                "status", "type"
            ])
            ->withOnly([])
            ->get();
    }

    /**
     * دریافت تمام کاربرها
     */
    public function statisticUsers(): Collection
    {
        return $this->userRepo->query()
            ->select([
                DB::raw("COUNT(*) AS count"),
                "status"
            ])
            ->groupBy("status")
            ->withOnly([])
            ->get();
    }

    /**
     * دریافت آمار نقش ها
     */
    public function statisticRoles(): Collection
    {
        return $this->roleRepo->query()
            ->select([
                "roles.id",
                "roles.name",
                "users.status",
                DB::raw("COUNT(*) AS count"),
            ])
            ->leftJoin("users", "users.role_id", "roles.id")
            ->groupBy(["roles.id", "users.status"])
            ->withOnly([])
            ->get();
    }

    /**
     * نمودار فعالیت جدول پست ها
     */
    public function chartPosts(array $filters = [])
    {
        return
            $this->postRepo->query()
            ->select([
                DB::raw("COUNT(*) AS count"),
                DB::raw('DATE_FORMAT(created_at , "%Y-%m-%d %H:%I") AS date')
            ])
            ->filterBy($filters)
            ->groupBy("date")
            ->withOnly([])
            ->get();
    }

    /**
     * نمودار فعالیت جدول بازدید ها
     */
    public function chartViews(array $filters = [])
    {
        return
            $this->viewRepo->query()
            ->select([
                DB::raw("COUNT(*) AS count"),
                DB::raw('DATE_FORMAT(created_at , "%Y-%m-%d %H:%I") AS date')
            ])
            ->filterBy($filters)
            ->groupBy("date")
            ->withOnly([])
            ->get();
    }
}

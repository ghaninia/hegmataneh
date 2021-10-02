<?php

namespace App\Services\Widget;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Repositories\Post\PostRepository;
use App\Repositories\Role\RoleRepository;
use App\Repositories\User\UserRepository;
use App\Services\Widget\WidgetServiceInterface;

class WidgetService implements WidgetServiceInterface
{
    protected $postRepo, $userRepo, $roleRepo;
    private $user;

    public function __construct(
        PostRepository $postRepo,
        UserRepository $userRepo,
        RoleRepository $roleRepo
    ) {
        $this->postRepo = $postRepo;
        $this->userRepo = $userRepo;
        $this->roleRepo = $roleRepo;
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
     * @param Carbon $from 
     * @param Carbon $to 
     * @param string $type 
     * @param string $status
     */
    public function chartPosts(Carbon $from = null, Carbon $to = null, string $type = null, string $status = null)
    {
        return
            $this->postRepo->query()
            ->select([
                DB::raw("COUNT(*) AS count"),
                DB::raw('DATE_FORMAT(created_at , "%Y-%m-%d %H:%I") AS date')
            ])
            ->when($this->user, function ($query) {
                $query->where("user_id", $this->user->id);
            })
            ->when($type, function ($query) use ($type) {
                $query->where("type", $type);
            })
            ->when($status, function ($query) use ($status) {
                $query->where("status", $status);
            })
            ->when($from, function ($query) use ($from) {
                $query->where("created_at", ">=", $from);
            })
            ->when($to, function ($query) use ($to) {
                $query->where("created_at", "<=", $to);
            })
            ->groupBy("date")
            ->withOnly([])
            ->get();
    }
}

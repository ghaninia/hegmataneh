<?php

namespace App\Services\Widget;

use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use App\Models\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Services\Widget\WidgetServiceInterface;

class WidgetService implements WidgetServiceInterface
{
    private $user = null ;

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get all the activities in the user model table
     * @return Collection
     */
    public function statisticPosts(): Collection
    {

        return Post::query()
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
     * get statistic Users
     * @return Collection
     */
    public function statisticUsers(): Collection
    {
        return User::query()
            ->select([
                DB::raw("COUNT(*) AS count"),
                "status"
            ])
            ->groupBy("status")
            ->withOnly([])
            ->get();
    }

    /**
     * get statistic Roles
     * @return Collection
     */
    public function statisticRoles(): Collection
    {
        return Role::query()
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
     * get chart posts
     * @param array $filters
     * @return mixed
     */
    public function chartPosts(array $filters = [])
    {
        return
            Post::query()
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
     * get chart views
     * @param array $filters
     * @return mixed
     */
    public function chartViews(array $filters = [])
    {
        return
            View::query()
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

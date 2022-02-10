<?php

namespace App\Services\Access;

use App\Models\Role;
use App\Models\User;
use App\Services\Access\AccessServiceInterface;

class AccessService implements AccessServiceInterface
{

    public $user, $permissions;


    /**
     * user setter
     * @param User $user
     */
    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * permissions setter
     * @param $permissions
     */
    public function setPermissions($permissions): self
    {
        $permissions = is_string($permissions)  ? [$permissions] : $permissions ;
        $this->permissions = $permissions;
        return $this;
    }

    /**
     * بررسی وجود یا عدم وجود نقشی که کاربر دارد
     * @param string $operator
     * @return bool
     */
    private function checkLogic(string $operator): bool
    {
        $result =
            Role::query()
            ->whereHas(
                "users",
                fn ($query) => $query->where("users.id", $this->user->id)
            )
            ->whereHas(
                "permissions",
                function ($query) {
                    $query
                        ->whereIn("permissions.action", $this->permissions)
                        ->orWhereIn("permissions.key", $this->permissions);
                },
                $operator,
                count($this->permissions)
            )
            ->count();

        return empty($this->permissions) ? false : $result;
    }

    /**
     * بررسی سطح دسترسی تمام ورودی ها اجباری میباشد
     * تمام نقش ها را باید دارا باشد
     * @param User $user
     * @param array $permissions
     * @return boolean
     */
    public function fullAbility(): bool
    {
        return $this->checkLogic("=");
    }

    /**
     * بررسی میشود که حداقل یک مورد تشابه بین دسترسی ها موجود باشد
     * @param User $user
     * @param array $permissions
     * @return boolean
     */
    public function sufficientAbility(): bool
    {
        return $this->checkLogic(">=");
    }
}

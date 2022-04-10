<?php

namespace App\Services\Access;

use App\Models\Role;
use App\Models\User;
use App\Services\Access\AccessServiceInterface;

class AccessService implements AccessServiceInterface
{
    private $user, $permissions;

    /**
     * user setter
     * @param User $user
     * @return $this
     */
    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * set permissions
     * @param $permissions
     * @return $this
     */
    public function setPermissions($permissions): self
    {
        $permissions = is_string($permissions)  ? [$permissions] : $permissions ;
        $this->permissions = $permissions;
        return $this;
    }

    /**
     * Check for the presence or absence of a role that the user has
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
     * Checking the access level of all inputs is mandatory
     * Must have all roles
     * @return bool
     */
    public function fullAbility(): bool
    {
        return $this->checkLogic("=");
    }

    /**
     * Check that there is at least one similarity between the accesses
     * @return bool
     */
    public function sufficientAbility(): bool
    {
        return $this->checkLogic(">=");
    }
}

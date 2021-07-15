<?php

namespace App\Services\Role;

use App\Models\Role;
use App\Models\User;
use App\Repositories\Role\RoleRepository;
use App\Services\Role\RoleServiceInterface;

class RoleService implements RoleServiceInterface
{

    protected $roleRepo;

    public function __construct(RoleRepository $roleRepo)
    {
        $this->roleRepo = $roleRepo;
    }

    /**
     * بررسی سطح دسترسی تمام ورودی ها اجباری میباشد
     * @param User $user
     * @param array $permissions
     * @return boolean
     */
    public function fullCan(User $user, array $permissions): bool
    {
        $permissionsUser = $user->role->permissions;
        return !count(
            array_diff($permissions, $permissionsUser)
        );
    }

    /**
     * بررسی میشود که حداقل یک مورد تشابه بین دسترسی ها موجود باشد
     * @param User $user
     * @param array $permissions
     * @return boolean
     */
    public function enoughCan(User $user, array $permissions): bool
    {
        $permissionsUser = $user->role->permissions;
        return array_diff($permissions, $permissionsUser) < count($permissions);
    }

    /**
     * نمایش لیست تمام نقش ها
     * @return Collection
     */
    public function all()
    {
        return $this->roleRepo->all();
    }

    /**
     * ساخت نقش جدید
     * @param array $data
     * @return Role
     */
    public function create(array $data): Role
    {
        return
            $this->roleRepo->create([
                "name" => $data["name"],
                "permissions" => $data["permissions"],
            ]);
    }

    /**
     * ویرایش نقش کاربری
     * @param Role $role
     * @parma array $data
     * @return Role
     */
    public function update(Role $role, array $data): Role
    {
        $role->update([
            "name" => $data["name"],
            "permissions" => $data["permissions"],
        ]);

        return $role->refresh();
    }

    /**
     * حذف نقش کاربری
     * @param Role $role
     * @return boolean
     */
    public function delete(Role $role): bool
    {
        return $role->delete();
    }
}

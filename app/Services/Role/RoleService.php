<?php

namespace App\Services\Role;

use App\Models\Role;
use App\Repositories\Role\RoleRepository;
use App\Services\Role\RoleServiceInterface;

class RoleService implements RoleServiceInterface
{

    protected $roleRepo;

    public function __construct(
        RoleRepository $roleRepo
    ) {
        $this->roleRepo = $roleRepo;
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
        $role = $this->roleRepo->create([
                "name" => $data["name"],
            ]);

        $role->permissions()->sync($data["permissions"]);

        return $role ;
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
        ]);
        $role->permissions()->sync($data["permissions"]);
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

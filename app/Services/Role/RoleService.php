<?php

namespace App\Services\Role;

use App\Models\Role;
use App\Services\Role\RoleServiceInterface;

class RoleService implements RoleServiceInterface
{

    /**
     * get all roles
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return Role::all();
    }

    /**
     * create new role
     * @param array $data
     * @return Role
     */
    public function create(array $data): Role
    {
        $role = Role::create([
                "name" => $data["name"],
            ]);

        $role->permissions()->sync($data["permissions"]);

        return $role ;
    }

    /**
     * update role
     * @param Role $role
     * @param array $data
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
     * delete role
     * @param Role $role
     * @return bool
     */
    public function delete(Role $role): bool
    {
        return $role->delete();
    }
}

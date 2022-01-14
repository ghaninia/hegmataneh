<?php

namespace Tests\Builders;

use App\Models\Role;
use App\Models\User;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Permission;
use Illuminate\Support\Collection;

class UserBuilder
{
    private $permissions = [], $isAction = true;

    public function setPermission($permissions = [], $isAction = true)
    {
        $this->permissions = $permissions;
        $this->isAction = $isAction;
        return $this;
    }

    public function create($isCreate = true, $state = [], $count = 1)
    {
        $user = User::factory()
            ->for(
                Role::factory()
                    ->hasAttached($this->getPermissions(), [], "permissions")
            )
            ->for(
                Currency::factory()
            )
            ->for(
                Language::factory()
            )
            ->state($state);

        $user = $count > 1 ? $user->count($count) : $user;

        return $isCreate ? $user->create() : $user->make();
    }

    private function getPermissions()
    {
        $keyColumn = $this->isAction ? 'action' : 'key';
        $permissions = count($this->permissions) ? $this->permissions : getEntireRoutesAction();

        $pers =
            array_map(
                fn ($permission) => [
                    $keyColumn => $permission,
                ],
                $permissions
            );

        $instancePermissions = new Collection();

        array_map(function ($permission) use (&$instancePermissions) {
            $instancePermissions->push(
                Permission::updateOrCreate($permission)
            );
        }, $pers);

        return $instancePermissions;
    }
}

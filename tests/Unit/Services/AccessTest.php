<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use App\Services\Access\AccessService;

class AccessTest extends TestCase
{
    protected $accessService;
    protected function setUp(): void
    {
        parent::setUp();
        $this->accessService = app(AccessService::class);
    }

    private function getUserHasFullAbilities()
    {
        return
            User::factory()->for(
                Role::factory()
                    ->hasAttached(
                        $this->getEntitePermissions()
                    )
            )
            ->create();
    }

    private function getEntitePermissions()
    {
        return Permission::whereNotNull("action")->get();
    }

    private function getEntitePermissionsToArray() : array
    {
        return $this->getEntitePermissions()->pluck("action")->toArray() ;
    }

    public function test_user_full_access_permissions_is_correct()
    {
        $service =
            $this->accessService
            ->setUser($this->getUserHasFullAbilities())
            ->setPermissions(
                $this->getEntitePermissionsToArray()
            )
            ->fullAbility();

        $this->assertTrue($service);
    }

    public function test_user_full_access_permissions_is_incorrect()
    {
        $service =
            $this->accessService
            ->setUser($this->getUserHasFullAbilities())
            ->setPermissions(
                array_merge(
                    ["problem"],
                    $this->getEntitePermissionsToArray()
                )
            )
            ->fullAbility();

        $this->assertFalse($service);
    }

    public function test_user_sufficient_access_permission_is_correct()
    {

        ### در صورتی که جزیی از دیتا وجود باشد
        $service =
            $this->accessService
            ->setUser($this->getUserHasFullAbilities())
            ->setPermissions(array_merge($this->getEntitePermissionsToArray(), ["test", "test2"]))
            ->sufficientAbility();
        $this->assertTrue($service);

        ### در صورتی که کل دیتا موجود نباشد
        $service =
            $this->accessService
            ->setUser($this->getUserHasFullAbilities())
            ->setPermissions(["problem1", "problem2"])
            ->sufficientAbility();
        $this->assertFalse($service);
    }
}

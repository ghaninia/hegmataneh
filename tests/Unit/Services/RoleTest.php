<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\Role;
use App\Models\Permission;
use App\Services\Role\RoleService;
use Illuminate\Database\Eloquent\Collection;

class RoleTest extends TestCase
{
    private function service()
    {
        return app(RoleService::class);
    }

    public function createPermissions($count)
    {
        return Permission::factory()
            ->count($count)
            ->create();
    }

    public function test_create_role()
    {
        $count = 5;

        $role = $this->service()->create([
            "name" => "::name::",
            "permissions" => $this->createPermissions($count)->pluck("id")->toArray()
        ]);

        $this->assertTrue($role instanceof Role);
        $this->assertDatabaseHas("roles", [
            "name" => "::name::",
            "id" => $role->id
        ]);
        $this->assertCount($count, $role->permissions);
        $this->assertTrue($role->permissions->first() instanceof Permission);
        return $role;
    }

    public function test_all_role()
    {
        $roles = $this->service()->all();
        $this->assertTrue($roles instanceof Collection);
        $this->assertEquals($roles->count(), Role::count());
    }

    /**
     * @depends test_create_role
     */
    public function test_update_role($role)
    {
        $count = 5 ;

        $role =
            $this->service()->update($role, [
                "name" => "::NAME2::",
                "permissions" => $this->createPermissions($count)->pluck("id")->toArray()
            ]);

        $this->assertTrue($role instanceof Role);
        $this->assertDatabaseHas("roles", [
            "name" => "::NAME2::",
            "id" => $role->id
        ]);
        $this->assertCount($count, $role->permissions);
        $this->assertTrue($role->permissions->first() instanceof Permission);


        return $role ;
    }

    /**
     * @depends test_update_role
     */
    public function test_delete_role($role)
    {
        $this->assertTrue($this->service()->delete($role));
    }
}

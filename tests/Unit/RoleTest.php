<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Core\Enums\EnumsRole;
use App\Services\Role\RoleService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
{
    /**
     * سطح دسترسی ورودی باید مورد تایید ما باشد
     *
     * @return void
     */
    // public function test_access_full_can()
    // {
    //     $user = User::whereHas("role", function ($query) {
    //         $query->whereJsonContains("permissions", EnumsRole::PERMISSION_USER);
    //     })
    //         ->first();

    //     return !!$user ? $this->assertTrue(
    //         app(RoleService::class)->fullCan(
    //             $user,
    //             [
    //                 EnumsRole::PERMISSION_USER
    //             ]
    //         )
    //     ) : $this->assertNull($user);
    // }

    /**
     * ساخت نقش جدید
     * @return void
     */
    public function test_create_role()
    {
        $role = app(RoleService::class)->create([
                "name" => "test",
                "permissions" => EnumsRole::all()
            ]);

        return $this->assertEquals($role->name, "test");
    }
}

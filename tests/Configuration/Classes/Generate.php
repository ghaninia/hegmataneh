<?php

namespace Tests\Configuration\Classes;

use App\Models\Role;
use App\Models\User;
use App\Core\Enums\EnumsUser;

class Generate
{
    public function user()
    {
        return
            User::factory()
            ->state([
                "password" => bcrypt("secret"),
                "status" => EnumsUser::STATUS_ENABLE
            ])
            ->for(
                Role::factory()
            )
            ->create();
    }
}

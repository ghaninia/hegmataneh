<?php
namespace Tests\Dependency\Traits;

use App\Models\User;
use Tests\Builders\UserBuilder;

trait ActingAsSystem
{
    public function signIn(...$params): User
    {
        $userBuilder = new UserBuilder;
        $userBuilder->setPermission(...$params);
        $user = $userBuilder->create();

        $this->actingAs($user);

        return $user;
    }
}

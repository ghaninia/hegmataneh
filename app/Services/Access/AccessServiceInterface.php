<?php

namespace App\Services\Access;

use App\Models\User;

interface AccessServiceInterface
{
    public function setUser(User $user): self;
    public function setPermissions($permissions): self;
    public function fullAbility(): bool;
    public function sufficientAbility(): bool;
}

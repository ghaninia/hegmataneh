<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\Paginator;

interface UserServiceInterface
{
    public function updateOrCreate(array $data, User $user = null): User;
    public function delete(User $user): bool;
    public function restore(User $user): bool;
    public function sendVerifyNotification(User $user): void;
    public function verify(string $token): ?User;
    public function rememberTokenGenerate(): string;
    public function list(array $filters): Paginator|Collection;
}

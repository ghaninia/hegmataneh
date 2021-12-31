<?php

namespace App\Services\Authunticate;

use App\Models\User;

interface AuthServiceInterface
{
    public function field() ;
    public function login(array $credintioal, bool $remember = FALSE): bool ;
    public function user(): ?User ;
    public function id() ;
    public function can(string $ability,  $parameters): bool ;
}

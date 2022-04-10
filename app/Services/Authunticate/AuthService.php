<?php

namespace App\Services\Authunticate;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\Authunticate\AuthServiceInterface;

class AuthService implements AuthServiceInterface
{

    public function field()
    {
        return "email";
    }

    /**
     * User based authentication based on input
     * @param array $credintioal
     * @param bool $remember
     * @return bool
     */
    public function login(array $credintioal, bool $remember = FALSE): bool
    {
        return Auth::attempt($credintioal, $remember);
    }

    /**
     * get auth user
     * @return User|null
     */
    public function user(): ?User
    {
        return Auth::user();
    }

    /**
     * Get a logged in user ID
     * @return int|string|null
     */
    public function id()
    {
        return Auth::id();
    }

    /**
     * Ability to access the user
     * @param string $ability
     * @param $parameters
     * @return bool
     */
    public function can(string $ability,  $parameters): bool
    {
        return $this->user()->can($ability, $parameters);
    }
}

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
     * احراز هویت کاربر بر اساس ورودی
     * @param array $credintioal
     * @param boolean $remember
     * @return boolean
     */
    public function login(array $credintioal, bool $remember = FALSE): bool
    {
        return Auth::attempt($credintioal, $remember);
    }

    /**
     * بررسی کاربر لاگین شده
     * @return User || false
     */
    public function user(): User
    {
        return Auth::user();
    }

    /**
     * دریافت آیدی کاربر لاگین شده
     * @return integer || false
     */
    public function id()
    {
        return Auth::id();
    }

    /**
     * توانایی دسترسی کاربر
     * @return boolean
     */
    public function can(string $ability,  $parameters): bool
    {
        return $this->user()->can($ability, $parameters);
    }
}

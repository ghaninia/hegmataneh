<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\User;
use Database\Seeders\UserSeeder;
use App\Services\Authunticate\AuthService;

class AuthunticateTest extends TestCase
{
    /**
     * @test
     */
    public function testLoginService()
    {
        $this->seed(UserSeeder::class);
        $user = User::first();
        $result = app(AuthService::class)->login([
            "username" => $user->username,
            "password" => "secret"
        ]);
        $this->assertTrue($result);
        $this->assertTrue($user instanceof User);
        $this->assertIsInt($user->id);
        return $user;
    }

}

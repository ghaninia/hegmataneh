<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Database\Seeders\UserSeeder;
use App\Services\Authunticate\AuthService;

class AuthunticateFeatureTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->seed(UserSeeder::class);
        $user = User::first();

        $field = app(AuthService::class)->field();

        $response = $this->post( route("authunticate.login"), [
            $field => $user->{$field},
            "password" => "secret"
        ]);

        $response->assertStatus(200) ;
    }
}

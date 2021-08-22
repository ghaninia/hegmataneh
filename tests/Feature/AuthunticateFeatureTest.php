<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Services\Authunticate\AuthService;

class AuthunticateFeatureTest extends TestCase
{

    protected $authService;
    protected function setUp(): void
    {
        parent::setUp();
        $this->authService = app(AuthService::class);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $user = User::first();

        $field = $this->authService->field();

        $response = $this->post(route("authunticate.login"), [
            $field => $user->{$field},
            "password" => "secret"
        ]);

        $response->assertStatus(200);
    }
}

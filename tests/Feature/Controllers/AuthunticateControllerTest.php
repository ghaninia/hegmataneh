<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Core\Enums\EnumsUser;
use App\Core\Enums\EnumsOption;
use App\Services\Authunticate\AuthService;
use Illuminate\Support\Facades\Notification;
use App\Contracts\Filters\PortfolioFilters\Name;

class AuthunticateControllerTest extends TestCase
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
    public function test_login_in_system()
    {
        $user = User::first();

        $field = $this->authService->field();

        $response = $this->post(route("authunticate.login"), [
            $field => $user->{$field},
            "password" => "secret"
        ]);

        $response->assertStatus(200);
    }

    public function test_user_can_register()
    {
        Notification::fake() ;
        Notification::assertNothingSent() ;

        options()->put(EnumsOption::DASHBOARD_CAN_REGISTER, TRUE);
        $response = $this->post(route("authunticate.register.store", [
            "name" => "amen" ,
            "email" => "amen@gmail.com" ,
            "mobile" => "09000000000" ,
            "username" => "amen" ,
            "password" => "secret" ,
            "bio" => "amen bio" ,
        ]));
        $response->assertStatus(200);
        $response->assertSee("ok");
    }
}

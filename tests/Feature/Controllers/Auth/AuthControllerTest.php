<?php

namespace Tests\Feature\Controllers\Auth;

use Tests\TestCase;
use App\Models\Option;
use App\Core\Enums\EnumsOption;
use App\Core\Enums\EnumsUser;
use App\Models\User;
use App\Notifications\ConfirmAccountNotification;
use Tests\Builders\UserBuilder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Authunticate\AuthServiceInterface;
use App\Services\Option\OptionService;
use Illuminate\Support\Facades\Notification;
use Tests\Builders\OptionBuilder;

class AuthControllerTest extends TestCase
{

    protected UserBuilder $userBuilder;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userBuilder = new UserBuilder;
    }

    public function testLoginToAccount()
    {
        $user = $this->userBuilder->create(TRUE, [
            "password" => bcrypt($password = "123456"),
        ]);

        $field = app(AuthServiceInterface::class)->field();

        $response = $this->post(route("authunticate.login"), [
            $field => $user->{$field},
            "password" => $password,
        ]);

        $response->assertJsonStructure([
            "user",
            "token",
            "ok"
        ]);
    }

    public function testRegisterOnTheSite()
    {
        Notification::fake();
        Notification::assertNothingSent();

        $user = $this->userBuilder->create(FALSE,);

        ### custom role
        OptionBuilder::set(EnumsOption::DASHBOARD_REGISTER_RULE, $user->role_id);

        $response = $this->postJson(
            route("authunticate.register.store"),
            $data = array_merge($user->toArray(), [
                "password" => "123456",
            ])
        );

        $this->assertDatabaseHas( "users" ,[
            "status" => EnumsUser::STATUS_DISABLE,
            'role_id' => $user->role_id ,
            "email" => $user->email,
            "username" => $user->username,
            "mobile" => $user->mobile,
        ]);

        $userId = $response->json("data.id") ;

        Notification::assertSentTo(
            User::find($userId),
            ConfirmAccountNotification::class
        );

        $response->assertJsonStructure([
            "msg",
            "data" => [
                'name',
                'status',
                'email',
                'mobile',
                "username",
                "bio",
                "created_at"
            ],
            "ok"
        ]);
    }
}

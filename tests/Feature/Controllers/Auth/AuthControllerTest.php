<?php

namespace Tests\Feature\Controllers\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Core\Enums\EnumsUser;
use Illuminate\Http\Response;
use App\Core\Enums\EnumsOption;
use Tests\Builders\UserBuilder;
use Tests\Builders\OptionBuilder;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ConfirmAccountNotification;
use App\Services\Authunticate\AuthServiceInterface;

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

        $response = $this->post(route("api.v1.authunticate.login"), [
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
            route("api.v1.authunticate.register.store"),
            $data = array_merge($user->toArray(), [
                "password" => "123456",
            ])
        );

        $response->assertStatus(Response::HTTP_OK) ;


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

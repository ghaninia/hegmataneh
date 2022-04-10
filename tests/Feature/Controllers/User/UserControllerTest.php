<?php

namespace Tests\Feature\Controllers\User;

use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\Builders\UserBuilder;

class UserControllerTest extends TestCase
{
    protected UserBuilder $userBuilder;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userBuilder = new UserBuilder;
        $this->signIn() ;
    }

    public function testGetAllSystemUsersWithFilters()
    {

        $users = $this->userBuilder->create(true, [], $total = random_int(1, 10));

        $user = $users->first();

        $response = $this->getJson(
            route("api.v1.user.index", [
                "name" => $user->name,
                "username" => $user->username,
                "email" => $user->email,
                "mobile" => $user->mobile,
                "status" => $user->status,
                "role_id" => $user->role_id,
                "just_trashed" => false
            ])
        );


        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(1, "data");
        $response->assertJsonPath("data.0.id", $user->id);
        $response->assertJsonStructure([
            "data" => [
                "*" => [
                    "currency",
                    "language",
                    "role",
                    "id",
                    "name",
                    "username",
                    "email",
                    "status",
                ]
            ],
            "links",
            "meta"
        ]);
    }

    public function testGetAllSystemUsersWithoutFilters()
    {
        $this->userBuilder->create(true, [], $total = random_int(1, 10));
        $response = $this->getJson(route("api.v1.user.index"));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                "meta" => [
                    "total" => $total + 1 // 1 is auth user
                ]
            ]);
    }

    public function testCreateNewUserOnSystem()
    {
        $user = $this->userBuilder->create(false);

        $response = $this->postJson(
            route("api.v1.user.store"),
            array_merge(
                $user->toArray(),
                ["password" => "secret"]
            )
        );

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            "ok",
            "msg",
            "data" => [
                "id",
                "name",
                "status",
                "email",
                "mobile",
                "username",
                "bio",
                "created_at",
            ]
        ]);

        $this->assertDatabaseHas("users", [
            "language_id" => $user->language_id,
            "currency_id" => $user->currency_id,
            "role_id" => $user->role_id,
            "username" => $user->username,
            "mobile" => $user->mobile,
            "email" => $user->email,
            "status" => $user->status,
            "name" => $user->name,
        ]);
    }

    public function testShowAUserOnSystem()
    {
        $user = $this->userBuilder->create(true);

        $response = $this->getJson(
            route("api.v1.user.show", [
                "user" => $user->id
            ])
        );

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            "data" => [
                "currency",
                "language",
                "role",
                "id",
                "name",
                "username",
                "email",
                "status",
            ],
        ]);
    }

    public function testUpdateUserOnSystem()
    {
        $user = $this->userBuilder->create(true);
        $newUser = $this->userBuilder->create(false);

        $response = $this->putJson(
            route("api.v1.user.update", ["user" => $user->id]),
            $newUser->toArray()
        );

        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas("users", [
            "language_id" => $newUser->language_id,
            "currency_id" => $newUser->currency_id,
            "role_id" => $newUser->role_id,
            "username" => $newUser->username,
            "mobile" => $newUser->mobile,
            "email" => $newUser->email,
            "status" => $newUser->status,
            "name" => $newUser->name,
        ]);

        $response->assertJsonStructure([
            "data" => [
                "currency",
                "language",
                "role",
                "id",
                "name",
                "username",
                "email",
                "status",
            ],
        ]);
    }

    public function testUpdateUserPassword()
    {
        $user = $this->userBuilder->create(true);
        $newUser = $this->userBuilder->create(false);

        $response = $this->putJson(
            route("api.v1.user.update", ["user" => $user->id]),
            array_merge(
                $newUser->toArray(),
                [
                    "password" => $password = "secret"
                ]
            )
        );

        $response->assertStatus(Response::HTTP_OK);

        $user = $user->refresh();

        $this->assertTrue(
            Hash::check($password, $user->password)
        );
    }


    public function testDeleteUserInSystem()
    {
        $user = $this->userBuilder->create(true);

        $response = $this->deleteJson(
            route("api.v1.user.update", ["user" => $user->id])
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            "ok",
            "msg"
        ]);

        $this->assertSoftDeleted("users", [
            "id" => $user->id
        ]);
    }
}

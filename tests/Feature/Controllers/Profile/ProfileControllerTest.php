<?php

namespace Tests\Feature\Controllers\Profile;

use App\Models\Currency;
use App\Models\Language;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\Builders\UserBuilder;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{

    public UserBuilder $userBuilder ;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userBuilder = new UserBuilder() ;
    }

    /** @test */
    public function showProfile()
    {
        Sanctum::actingAs(
            $this->userBuilder->create()
        );

        $response = $this->getJson(
            route("api.v1.profile.index")
        );

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                "data" => [
                    'id',
                    "is_trashed",
                    'name',
                    'status',
                    'email',
                    'mobile',
                    "username",
                    "bio",
                    "created_at",
                    "role",
                    "currency",
                    "language",
                ]
            ]);

    }


    /** @test */
    public function updateProfile()
    {
        Sanctum::actingAs(
            $auth = $this->userBuilder->create()
        );

        $user =
            User::factory()
            ->for(Language::factory()->create())
            ->for(Currency::factory()->create())
            ->make() ;

        unset($user->status , $user->remember_token ) ;

        $response = $this->postJson(
            route("api.v1.profile.store") ,
            array_merge(
                $user->toArray() ,
                [
                    "password" => bcrypt("secret")
                ]
            )
        );

        $this->assertDatabaseHas("users" , $user->toArray() ) ;

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                "data" => [
                    'id',
                    "is_trashed",
                    'name',
                    'status',
                    'email',
                    'mobile',
                    "username",
                    "bio",
                    "created_at",
                    "role",
                    "currency",
                    "language",
                ]
            ]);

        $this->assertTrue(
            Hash::check("secret" , $auth->refresh()->password )
        );
    }
}

<?php

namespace Tests\Feature\Controllers\Widget;

use Tests\TestCase;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use App\Models\Currency;
use App\Models\Language;
use Illuminate\Http\Response;
use App\Kernel\Enums\EnumsPost;

class WidgetControllerTest extends TestCase
{
    /** @test */
    public function statisticPosts()
    {
        $user = $this->signIn();

        Post::factory()
            ->for($user)
            ->count(10)
            ->state([
                "status" => EnumsPost::STATUS_PUBLISHED,
                "type" => EnumsPost::TYPE_POST
            ])
            ->create();

        $route = route("api.v1.widget.statistic.posts");
        $response = $this->getJson($route);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                0 => [
                    "count" => 10,
                    "status" => EnumsPost::STATUS_PUBLISHED,
                    "type" => EnumsPost::TYPE_POST
                ]
            ]);
    }

    /** @test */
    public function statisticUsers()
    {
        $user = $this->signIn();

        User::factory()
            ->for(Role::factory())
            ->for(Currency::factory())
            ->for(Language::factory())
            ->count(random_int(1, 10))
            ->create();

        $route = route("api.v1.widget.statistic.users");
        $response = $this->getJson($route);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                "*" => [
                    "count",
                    "status"
                ]
            ]);
    }
}

<?php

namespace Tests\Feature\Controllers\Widget;

use App\Kernel\Enums\EnumsPost;
use Tests\TestCase;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

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
}

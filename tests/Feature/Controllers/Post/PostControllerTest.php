<?php

namespace Tests\Feature\Controllers\Post;

use App\Kernel\Enums\EnumsPost;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    protected $auth ;
    public function setUp(): void
    {
        parent::setUp();
        $this->auth = $this->signIn() ;
    }

    /** @test */
    public function getPostsList()
    {
        Post::factory()
            ->state([
                "type" => EnumsPost::TYPE_POST
            ])
            ->for($this->auth)
            ->count(10)
            ->create();

        $this
            ->getJson(
                route("api.v1.user.post.index" , [
                    "user" => $this->auth->id
                ])
            )
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                "meta" => [
                    "total" => 10
                ],
            ]);
    }
}

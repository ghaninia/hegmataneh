<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\Post;
use App\Models\Role;
use App\Models\Term;
use App\Models\User;
use App\Models\Language;
use App\Core\Enums\EnumsPost;
use App\Core\Enums\EnumsTerm;
use Laravel\Passport\Passport;
use App\Http\Middleware\AccessMiddleware;
use Illuminate\Foundation\Testing\WithFaker;

class PostControllerTest extends TestCase
{

    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        Passport::actingAs($this->createUser());
    }

    private function createTags()
    {
        return
            Term::factory()
            ->count(10)
            ->state(["type" => EnumsTerm::TYPE_TAG])
            ->create()
            ->pluck("id")
            ->toArray();
    }

    private function createCats()
    {
        return
            Term::factory()
            ->count(10)
            ->state(["type" => EnumsTerm::TYPE_CATEGORY])
            ->create()
            ->pluck("id")
            ->toArray();
    }

    private function createUser()
    {
        return
            User::factory()
            ->for(Role::factory())
            ->create();
    }

    public function test_create_new_post()
    {
        $this->withoutMiddleware(AccessMiddleware::class);

        $user = $this->createUser();

        $tags = $this->createTags();
        $categories =  $this->createCats();

        $post = post::factory()->make();

        $language = Language::factory()->create();

        $response = $this->postJson(route("user.post.store", $user->id), [
            "status" =>  $post->status,
            "comment_status" => $post->comment_status,
            "vote_status" => $post->vote_status,
            "format" => $post->format,
            "published_at" => $post->published_at,
            "created_at" => $post->created_at,
            "tags" => $tags,
            "categories" => $categories,
            "translations" => [
                $language->id => [
                    EnumsPost::FIELD_TITLE => $this->faker->slug(),
                    EnumsPost::FIELD_CONTENT => $this->faker->realText(),
                    EnumsPost::FIELD_EXCERPT => $this->faker->realText(),
                    EnumsPost::FIELD_FAQ => $this->faker->text()
                ]
            ]
        ]);

        $response->assertStatus(200);
        $response->assertSee("ok");
        $response->assertSee("msg");
    }


    public function test_show_post()
    {
        $this->withoutMiddleware(AccessMiddleware::class);

        $post = Post::factory()
            ->state([
                "type" => EnumsPost::TYPE_POST
            ])
            ->for(
                $user = $this->createUser(),
                "user"
            )
            ->create();

        $response = $this->getJson(route("user.post.show", [
            "user" => $user->id,
            "post" => $post->id
        ]));

        $response->assertStatus(200);
    }



    public function test_update_post()
    {
        $this->withoutMiddleware(AccessMiddleware::class);

        $post = Post::factory()
            ->state([
                "type" => EnumsPost::TYPE_POST
            ])
            ->for($this->createUser())
            ->create();

        $fakePost = Post::factory()->make();
        $language = Language::factory()->create();

        $response = $this->putJson(route("user.post.update", [
            "user" => $post->user->id,
            "post" => $post->id
        ]), [
            "status" =>  $fakePost->status,
            "comment_status" => $fakePost->comment_status,
            "vote_status" => $fakePost->vote_status,
            "format" => $fakePost->format,

            "published_at" => $fakePost->published_at,
            "created_at" => $fakePost->created_at,
            "tags" => [],
            "categories" => [],
            "translations" => [
                $language->id => [
                    EnumsPost::FIELD_TITLE => $this->faker->slug(),
                    EnumsPost::FIELD_CONTENT => $this->faker->realText(),
                    EnumsPost::FIELD_EXCERPT => $this->faker->realText(),
                    EnumsPost::FIELD_FAQ => $this->faker->text()
                ]
            ]
        ]);

        $response->assertStatus(200);
        $response->assertSee("ok");
        $response->assertSee("msg");
    }
}

<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\Post;
use App\Models\Role;
use App\Models\Term;
use App\Models\User;
use App\Core\Enums\EnumsPost;
use App\Core\Enums\EnumsTerm;
use Laravel\Passport\Passport;
use App\Http\Middleware\AccessMiddleware;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PostControllerTest extends TestCase
{
    use WithoutMiddleware ;

    protected function setUp(): void
    {
        parent::setUp() ;
        $this->withoutMiddleware(AccessMiddleware::class) ;
        Passport::actingAs($this->createUser()) ;
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
        $user = $this->createUser();

        $tags = $this->createTags();
        $categories =  $this->createCats();

        $post = post::factory()->make();

        $response = $this->json( "POST" ,route("user.post.store", $user->id), [
            "title" => $post->title,
            "slug" => $post->slug,
            "status" =>  $post->status,
            "comment_status" => $post->comment_status,
            "vote_status" => $post->vote_status,
            "format" => $post->format,
            "content" => $post->content,
            "excerpt" => $post->excerpt,
            "faq" => $post->faq,

            "published_at" => $post->published_at,
            "created_at" => $post->created_at,

            "tags" => $tags,
            "categories" => $categories
        ]);

        $response->assertStatus(200);
        $response->assertSee("ok");
        $response->assertSee("msg");
    }


    public function test_show_post()
    {
        $post = Post::factory()
            ->state([
                "type" => EnumsPost::TYPE_POST
            ])
            ->for(
                $user = $this->createUser(),
                "user"
            )
            ->create();

        $response = $this->json(  "GET" , route("user.post.show", [
            "user" => $user->id,
            "post" => $post->id
        ]));

        $response->assertStatus(200);
        $response->assertSee("id");
        return $post;
    }

    /**
     * @depends test_show_post
     */
    public function test_update_post($post)
    {
        $user = $post->user;
        $fakePost = Post::factory()->make();
        $response = $this->json( "PUT" ,route("user.post.update", [
            "user" => $user->id,
            "post" => $post->id
        ]), [
            "title" => $fakePost->title,
            "slug" => $fakePost->slug,
            "status" =>  $fakePost->status,
            "comment_status" => $fakePost->comment_status,
            "vote_status" => $fakePost->vote_status,
            "format" => $fakePost->format,
            "content" => $fakePost->content,
            "excerpt" => $fakePost->excerpt,
            "faq" => $fakePost->faq,

            "published_at" => $fakePost->published_at,
            "created_at" => $fakePost->created_at,
            "tags" => [],
            "categories" => []
        ], [
            "content-type" => "application/x-www-form-urlencoded"
        ]);

        $response->assertStatus(200);
        $response->assertSee("ok");
        $response->assertSee("msg");
    }
}

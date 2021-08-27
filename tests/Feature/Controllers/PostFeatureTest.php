<?php

namespace Tests\Feature\Controllers;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Post;
use App\Models\Role;
use App\Models\Term;
use App\Models\User;
use App\Core\Enums\EnumsPost;
use App\Core\Enums\EnumsTerm;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PostFeatureTest extends TestCase
{
    use WithoutMiddleware;

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

    public function test_when_request_for_create_new_post()
    {
        $this->withoutMiddleware();
        $user = $this->createUser();
        $tags = $this->createTags();
        $categories =  $this->createCats();

        $response = $this->post(route("user.post.store", $user->id), [
            "title" => "::TITLE::",
            "slug" =>  "::SLUG::",
            "status" => EnumsPost::STATUS_PUBLISHED,
            "comment_status" => TRUE,
            "vote_status" => TRUE,
            "format" => EnumsPost::FORMAT_CONTEXT,
            "content" => "::CONTENT::",
            "excerpt" => "::EXCERPT::",
            "faq" => "::FAQ::",

            "published_at" => Carbon::now()->format("y/m/d"),
            "created_at" =>  Carbon::now()->format("y/m/d"),

            "tags" => $tags,
            "categories" => $categories
        ]);

        $response->assertStatus(200);
        $response->assertSee("ok");
    }
}

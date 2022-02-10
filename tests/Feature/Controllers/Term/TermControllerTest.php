<?php

namespace Tests\Feature\Controllers\Term;

use App\Core\Enums\EnumsTerm;
use App\Models\Language;
use App\Models\Slug;
use App\Models\Term;
use App\Models\Translation;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Tests\TestCase;

class TermControllerTest extends TestCase
{
    protected User $authUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authUser = $this->signIn();
    }

    public function testGetAllTags()
    {
        $language = Language::factory()->create();

        $tags =
            Term::factory()
            ->state([
                "type" => EnumsTerm::TYPE_TAG
            ])
            ->has(
                Translation::factory()->for($language)->state([
                    "field" => EnumsTerm::FIELD_NAME,
                ])
            )
            ->has(
                Slug::factory()->for($language)
            )
            ->count($total = random_int(1, 5))
            ->create();

        $tag = $tags->first();

        $response = $this->get(
            route("api.v1.tag.index", [
                "id"  => $tag->id,
                "name" => $tag->name,
                "description" => $tag->description,
                "slug" => $tag->slug,
            ])
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                "data" => [
                    "*" => [
                        "id",
                        "created_at",
                        "translations" => [
                            "*" => [
                                "*" => [
                                    "field",
                                    "trans",
                                ]
                            ]
                        ],
                        "slugs" => [
                            "*" => [
                                "*" => [
                                    "slug",
                                ]
                            ]
                        ]
                    ]
                ],
                "meta",
                "links"
            ]);
    }

    public function testCreateNewTag()
    {
    }
}

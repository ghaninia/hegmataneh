<?php

namespace Tests\Feature\Controllers\Term;

use App\Kernel\Enums\EnumsFile;
use App\Kernel\Enums\EnumsTerm;
use App\Kernel\Slug\Slugify;
use App\Models\Language;
use App\Models\Slug;
use App\Models\Term;
use App\Models\Translation;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Tests\TestCase;

class TermControllerTest extends TestCase
{
    protected User $authUser;

    use WithFaker ;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authUser = $this->signIn();
    }

    /** all tags */
    public function getTags()
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

    /** @test */
    public function newTag()
    {

        $tag = Term::factory()
            ->state([
                "type" => EnumsTerm::TYPE_TAG ,
            ])
            ->make();

        $language = Language::factory()->create() ;

        $response = $this->postJson(
            route("api.v1.tag.store") ,
            array_merge(
                $tag->toArray() ,
                [
                    "translations" => [
                        $language->id => [
                            EnumsTerm::FIELD_NAME => $name =  $this->faker->text() ,
                            EnumsTerm::FIELD_DESCRIPTION => $description = $this->faker->realText()
                        ]
                    ]
                ] ,
            )
        );

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                "ok" ,
                "msg" ,
                "data" => [
                    "id" ,
                    "created_at"
                ]
            ])
            ->assertJson([
                "ok" => true ,
                "data" => [

                    "slugs" => [
                        $language->code => [
                            [
                                "slug" => Slugify::create($name)
                            ]
                        ]
                    ] ,

                    "translations" => [
                        $language->code => [
                            [
                                "field" => EnumsTerm::FIELD_NAME ,
                                "trans" => $name
                            ] ,
                            [
                                "field" => EnumsTerm::FIELD_DESCRIPTION ,
                                "trans" => $description
                            ]
                        ] ,
                    ]
                ]
            ]);

    }

    /** @test */
    public function errorSlugWhenExists()
    {
        $tag = Term::factory()
            ->state([
                "type" => EnumsTerm::TYPE_TAG ,
            ])
            ->has(
                Slug::factory()
                    ->state([
                        "slug" => $slug = $this->faker->slug()
                    ])
                    ->for(
                        $language = Language::factory()->create()
                    )
            )
            ->create();

        $response = $this->postJson(
            route("api.v1.tag.store" ) ,
            [
                "translations" => [
                    $language->id => [
                        EnumsTerm::FIELD_NAME => $slug ,
                        EnumsTerm::FIELD_DESCRIPTION => $this->faker->text()
                    ]
                ]
            ]
        );

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                "translations.{$language->id}.name"
            ]);
    }

    /** @test */
    public function updateTag()
    {
        $tag = Term::factory()
            ->state([
                "type" => EnumsTerm::TYPE_TAG ,
            ])
            ->has(
                Slug::factory()
                    ->state([
                        "slug" => $slug = $this->faker->slug()
                    ])
                    ->for(
                        $language = Language::factory()->create()
                    )
            )
            ->has(
                Translation::factory()
                    ->for($language)
                    ->state([
                        "field" => EnumsTerm::FIELD_NAME ,
                        "trans" => $this->faker->text() ,
                    ])
            )
            ->has(
                Translation::factory()
                    ->for($language)
                    ->state([
                        "field" => EnumsTerm::FIELD_DESCRIPTION ,
                        "trans" => $this->faker->text() ,
                    ])
            )
            ->create();

        $response = $this->putJson(
            route("api.v1.tag.update" , $tag) , [
                "translations" => [
                    $language->id => [
                        EnumsTerm::FIELD_NAME => $newName = $this->faker->text() ,
                        EnumsTerm::FIELD_DESCRIPTION => $newDescription = $this->faker->text() ,
                    ]
                ]
            ]
        );

        $this->assertDatabaseCount("translations" , 2) ;
        $this->assertDatabaseCount("slugs" , 1) ;

        foreach ([
             [
                 "field" => EnumsTerm::FIELD_NAME ,
                 "trans" => $newName
             ] , [
                "field" => EnumsTerm::FIELD_NAME ,
                "trans" => $newName
            ]
         ] as $translate ) {
            $this->assertDatabaseHas("translations" , $translate );
        }

        $this->assertDatabaseHas("slugs" , [
            "slugable_id" => $tag->id ,
            "slugable_type" => $tag->getMorphClass() ,
            "language_id" => $language->id ,
            "slug" => Slugify::create($newName)
        ]);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                "data" => [
                    "id" ,
                    "created_at" ,
                    "translations" ,
                    "slugs"
                ] ,
                "msg" ,
                "ok"
            ]);
    }


    /** @test */
    public function deleteTag()
    {
        $tag = Term::factory()
            ->state([
                "type" => EnumsTerm::TYPE_TAG ,
            ])
            ->has(
                Slug::factory()
                    ->state([
                        "slug" => $slug = $this->faker->slug()
                    ])
                    ->for(
                        $language = Language::factory()->create()
                    )
            )
            ->has(
                Translation::factory()
                    ->for($language)
                    ->state([
                        "field" => EnumsTerm::FIELD_NAME ,
                        "trans" => $this->faker->text() ,
                    ])
            )
            ->has(
                Translation::factory()
                    ->for($language)
                    ->state([
                        "field" => EnumsTerm::FIELD_DESCRIPTION ,
                        "trans" => $this->faker->text() ,
                    ])
            )
            ->create();

        $response = $this->deleteJson(
            route("api.v1.tag.destroy" , $tag)
        );

        $response->assertJsonStructure([
            "ok" , "msg"
        ]) ;

        $this->assertDatabaseMissing("terms" , [
            "id" => $tag->id
        ]) ;

        $this->assertDatabaseCount("slugs" , 0 ) ;
        $this->assertDatabaseCount("translations" , 0 ) ;
    }

}

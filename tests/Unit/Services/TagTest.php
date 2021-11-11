<?php

namespace Tests\Unit\Services;

use App\Core\Enums\EnumsPost;
use Tests\TestCase;
use App\Models\Term;
use App\Models\Language;
use App\Core\Enums\EnumsTerm;
use App\Models\Post;
use App\Models\Role;
use App\Models\Slug;
use App\Models\Translation;
use App\Models\User;
use App\Services\Tag\TagService;
use Illuminate\Foundation\Testing\WithFaker;

class TagTest extends TestCase
{
    use WithFaker;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_create_new_tag()
    {
        $language = Language::factory()->create();

        $term = app(TagService::class)->updateOrCreate([
            "translations" => [
                $language->id => [
                    EnumsTerm::FIELD_NAME => $this->faker->sentence(5),
                    EnumsTerm::FIELD_DESCRIPTION => $this->faker->paragraph(5),
                ]
            ]
        ]);

        $this->assertInstanceOf(Term::class, $term);
        $this->assertEquals($term->type, EnumsTerm::TYPE_TAG);
        $this->assertDatabaseHas("terms", [
            "id" => $term->id
        ]);

        $this->assertDatabaseHas("translations", [
            "language_id" => $language->id,
            "translationable_type" => $term->getMorphClass(),
            "translationable_id" => $term->id,
        ]);

        $this->assertDatabaseHas("slugs", [
            "language_id" => $language->id,
            "slugable_type" => $term->getMorphClass(),
            "slugable_id" => $term->id,
        ]);
    }

    public function test_update_tag()
    {
        $oldTag = Term::factory()
            ->state(["type" => EnumsTerm::TYPE_TAG])
            ->has(
                Translation::factory()->for(Language::factory())
            )
            ->create();

        $language = Language::factory()->create();

        $newTag = app(TagService::class)->updateOrCreate([
            "translations" => [
                $language->id => [
                    EnumsTerm::FIELD_NAME => $this->faker->sentence(5),
                    EnumsTerm::FIELD_DESCRIPTION => $this->faker->paragraph(5),
                ]
            ]
        ], $oldTag);

        $this->assertEquals($oldTag->id, $newTag->id);
        $this->assertEquals($newTag->translations->count(), 2);
        $this->assertDatabaseHas("translations", [
            "language_id" => $language->id,
            "translationable_id" => $oldTag->id,
            "translationable_type" => $oldTag->getMorphClass()
        ]);

        $this->assertEquals($newTag->slugs->count(), 1);
    }

    public function test_tag_delete()
    {
        $language = Language::factory();
        $tag = Term::factory()
            ->state(["type" => EnumsTerm::TYPE_TAG])
            ->has(
                Translation::factory()->for($language)
            )
            ->has(
                Slug::factory()->for($language)
            )
            ->create();

        $this->assertEquals($tag->translations->count(), 1);
        $this->assertEquals($tag->slugs->count(), 1);

        $result = app(TagService::class)->delete($tag);

        $this->assertTrue($result);

        $this->assertDatabaseMissing("terms", [
            "id" => $tag->id
        ]);

        $this->assertDatabaseMissing("translations", [
            "translationable_id" => $tag->id,
            "translationable_type" => $tag->getMorphClass()
        ]);

        $this->assertDatabaseMissing("slugs", [
            "slugable_id" => $tag->id,
            "slugable_type" => $tag->getMorphClass()
        ]);

        $this->assertDatabaseMissing("termables", [
            "term_id" => $tag->id,
        ]);
    }


    public function test_sync_tagable()
    {
        $language = Language::factory();

        $post = Post::factory()
            ->for(User::factory()->for(Role::factory()))
            ->has(
                Translation::factory()->for($language)->state(["field" => EnumsPost::FIELD_TITLE])
            )
            ->has(
                Slug::factory()->for($language)
            )
            ->create();

        $tags = Term::factory()
            ->has(
                Translation::factory()
                    ->for($language)
                    ->state(["field" => EnumsTerm::FIELD_NAME])
            )
            ->state(["type" => EnumsTerm::TYPE_TAG])
            ->count(random_int(0,10))
            ->create()
            ->pluck(["id"])
            ->toArray();

        app(TagService::class)->sync($post, $tags);

        $this->assertEquals(count($tags) , $post->tags()->count() ) ;
            
        $this->assertDatabaseHas("termables" , [
            "termable_id"   => $post->id , 
            "termable_type" => $post->getMorphClass() 
        ]);
    }
}

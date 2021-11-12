<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\Term;
use App\Models\Language;
use App\Core\Enums\EnumsTerm;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use App\Services\Category\CategoryService;
use Illuminate\Foundation\Testing\WithFaker;

class CategoryTest extends TestCase
{
    use WithFaker;

    protected $categoryService;

    public function setUp(): void
    {
        parent::setUp();
        $this->categoryService = app(CategoryService::class);
    }


    public function testCreateNewCategory()
    {
        $latestCategory = Term::factory()->state(["type" => EnumsTerm::TYPE_CATEGORY])->create();

        $language = Language::factory()->create();

        $translations = [
            $language->id => [
                EnumsTerm::FIELD_NAME => $this->faker->title(),
                EnumsTerm::FIELD_DESCRIPTION => $this->faker->sentence(),
            ]
        ];

        $category = $this->categoryService->updateOrCreate([
            "term_id" => $latestCategory->id,
            "color" => $this->faker->hexColor(),
            "translations" => $translations
        ]);

        $this->assertInstanceOf(Term::class, $category);

        $this->assertDatabaseHas("terms", [
            "id" => $category->id,
            "term_id" => $latestCategory->id
        ]);

        $this->assertDatabaseHas("translations", [
            "translationable_type" => $category->getMorphClass(),
            "translationable_id" => $category->id,
        ]);
    }

    public function testUpdateCategory()
    {
        $category = Term::factory()
            ->state([
                "type" => EnumsTerm::TYPE_CATEGORY
            ])
            ->create();

        $category = $this->categoryService->updateOrCreate([
            "color" => $this->faker->hexColor(),
        ], $category);

        $this->assertInstanceOf(Term::class, $category);
    }


    public function testDeleteCategory()
    {
        $category = Term::factory()
            ->state([
                "type" => EnumsTerm::TYPE_CATEGORY
            ])
            ->create();

        $this->categoryService->delete($category);

        $this->assertDatabaseMissing("terms", [
            "id" => $category->id,
            "term_id" => $category->id
        ]);
    }

    public function testSyncCategory()
    {
        $categories = Term::factory()
            ->state([
                "type" => EnumsTerm::TYPE_CATEGORY
            ])
            ->count(10)
            ->create()
            ->pluck("id")
            ->toArray();

        $post = Post::factory()->for(User::factory()->for(Role::factory()))->create();

        $this->categoryService->sync($post, $categories);
                
        foreach($categories as $category) {
            $this->assertDatabaseHas("termables", [
                "term_id" => $category,
                "termable_type" => $post->getMorphClass() ,
                "termable_id" => $post->id
            ]);
        }
        
    }
}

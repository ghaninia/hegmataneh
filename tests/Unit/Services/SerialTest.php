<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\Post;
use App\Models\Term;
use App\Models\Serial;
use App\Models\Currency;
use App\Models\Language;
use App\Core\Enums\EnumsPost;
use App\Core\Enums\EnumsTerm;
use App\Core\Enums\EnumsSerial;
use App\Core\Enums\EnumsEpisode;
use App\Services\Serial\SerialService;
use Tests\Configuration\Classes\Generate;
use Illuminate\Foundation\Testing\WithFaker;

class SerialTest extends TestCase
{
    use WithFaker;

    protected $serialService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->serialService = app(SerialService::class);
    }

    public function test_create_new_serial()
    {
        $user  = (new Generate)->user();

        $language = Language::factory()->create();
        $currency = Currency::factory()->create();

        $tags = Term::factory()->state(["type" => EnumsTerm::TYPE_TAG])->count(5)->create();
        $tags = $tags->pluck("id")->toArray();

        $categories = Term::factory()->state(["type" => EnumsTerm::TYPE_CATEGORY])->count(5)->create();
        $categories = $categories->pluck("id")->toArray();

        $posts = Post::factory()
            ->for($user)
            ->state(["type" => EnumsPost::TYPE_POST])
            ->count(random_int(1, 3))
            ->create();

        $episodes = [];

        $posts->each(function ($post) use (&$episodes, $language) {
            $episodes[$post->id] = [
                "translations" => [
                    $language->id => [
                        EnumsEpisode::FIELD_TITLE => $this->faker->title(),
                        EnumsEpisode::FIELD_DESCRIPTION => $this->faker->text()
                    ]
                ]
            ];
        });

        $result = $this->serialService->updateOrCreate($user, [
            "episodes" => [],
            "translations" => [
                $language->id => [
                    EnumsSerial::FIELD_TITLE => $this->faker->text(),
                    EnumsSerial::FIELD_DESCRIPTION => $this->faker->text(),
                ],
            ],
            "currencies" => [
                $currency->id => [
                    "price" => $this->faker->numerify("######")
                ]
            ],
            "tags" => $tags,
            "categories" => $categories,
        ]);

        $this->assertInstanceOf(Serial::class, $result);
    }


    public function test_append_episodes_to_serial()
    {
        $user = (new Generate)->user();
        $serial = Serial::factory()->for($user)->create();
        $posts = Post::factory()->for($user)->count(5)->create();
        $language = Language::factory()->create() ;
        
        $datas = [];

        $posts->map(function ($post) use (&$datas , $language ) {
            $datas[$post->id] = [
                "is_locked" => $this->faker->boolean(),
                "priority" => $this->faker->numerify("#"),
                "translations" => [
                    $language->id => [
                        EnumsEpisode::FIELD_TITLE => $this->faker->title() ,
                        EnumsEpisode::FIELD_DESCRIPTION => $this->faker->text() 
                    ]
                ]
            ];
        });

        $this->serialService
            ->episodes($serial, $datas);

        $this->assertEquals(
            $serial->episodes->count(),
            count($datas)
        );

        return $serial;
    }

    /**
     * @depends test_append_episodes_to_serial
     */
    public function test_delete_serial(Serial $serial)
    {
        $result = $this->serialService->delete($serial);
        $this->assertTrue($result);
    }
}

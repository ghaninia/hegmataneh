<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\Post;
use App\Models\Serial;
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
        $serial = Serial::factory()->make();
        $user  = (new Generate)->user();

        $result = $this->serialService->create($user, [
            "title" => $serial->title,
            "description" => $serial->description
        ]);

        $this->assertInstanceOf(Serial::class, $result);
    }


    public function test_append_episodes_to_serial()
    {
        $user = (new Generate)->user();
        $serial = Serial::factory()->for($user)->create();
        $posts  =  Post::factory()->for($user)->count(5)->create();

        $datas = [];

        $posts->map(function ($post) use (&$datas) {
            $datas[$post->id] = [
                "title" => $this->faker->title(),
                "is_locked" => $this->faker->boolean(),
                "priority" => $this->faker->numerify("#"),
                "description" => $this->faker->realText()
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

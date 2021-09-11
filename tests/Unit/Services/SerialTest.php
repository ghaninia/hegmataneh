<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\Serial;
use App\Models\PostSerial;
use App\Services\Serial\SerialService;
use Tests\Configuration\Classes\Generate;

class SerialTest extends TestCase
{
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
        $episodes = PostSerial::factory()->count(5)->make();

        $serial = Serial::factory()->for(
            (new Generate)->user()
        )->create();

        $this->serialService
            ->episodes($serial, $episodesCount = $episodes->toArray());

        $this->assertEquals(
            $serial->episodes->count(),
            count($episodesCount)
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

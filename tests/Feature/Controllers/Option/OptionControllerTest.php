<?php

namespace Tests\Feature\Controllers\Option;

use App\Kernel\Enums\EnumsOption;
use App\Models\Option;
use Illuminate\Http\Response;
use Tests\TestCase;

class OptionControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->signIn() ;
    }

    /** @test */
    public function getAllOptions()
    {
        Option::factory()->count($count = 5)->create() ;
        $this->get(route("api.v1.option.index"))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(5 , "data")
            ->assertJsonStructure([
                "data" => [
                    "*" => [
                        "title" ,
                        "key" ,
                        "type" ,
                        "value" ,
                        "default" ,
                    ]
                ]
            ]);
    }

    /** @test */
    public function editOptionSingleItem()
    {

        $option = Option::factory()
            ->state([
                "key" => EnumsOption::TITLE
            ])
            ->create() ;

        $this
            ->patchJson(route("api.v1.option.update") , [
                $option->key  => $value = "title one"
            ])
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                "msg" , "ok"
            ]);

        $this->assertDatabaseHas("options" , [
            "key" => $option->key ,
            "value" => serialize($value)
        ]);

    }

    /** @test */
    public function getSingleOption()
    {

        $option =
            Option::factory()
            ->state([
                "key" => EnumsOption::TITLE ,
                "value" => "title one"
            ])
            ->create() ;

        $response = $this->get(route("api.v1.option.index")) ;
        $response->assertStatus(Response::HTTP_OK);

        $data = $response->json("data.0") ;

        $this->assertSame( $data["value"] , "title one");

    }

}

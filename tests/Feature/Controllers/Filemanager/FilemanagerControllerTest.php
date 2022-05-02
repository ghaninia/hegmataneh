<?php

namespace Tests\Feature\Controllers\Filemanager;

use Tests\TestCase;
use App\Models\File;
use Illuminate\Http\Response;

class FilemanagerControllerTest extends TestCase
{
    /** @test */
    public function getAllFilesAndFolders()
    {
        $user = $this->signIn() ;

        File::factory()->for($user)->count(100)->create() ;

        $response = $this->getJson(
            route("api.v1.filemanager.index")
        );

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                "meta" => [
                    "total" => 100 ,
                    "last_page" => 1 ,
                    "current_page" => 0 ,
                    "next_page" => 1,
                ]
            ])
            ->assertJsonStructure([
                "data" => [
                    "*" => [
                        "id",
                        "created_at" ,
                        "updated_at" ,
                        "type",
                        "name",
                        "relpath",
                    ]
                ],
                "meta" => [
                    "total" ,
                    "last_page" ,
                    "current_page" ,
                    "next_page" ,
                ]
            ]);
    }

    /** @test */
    public function getAllFilesWithNameFilter()
    {
        $user = $this->signIn() ;

        File::factory()->for($user)->count(10)->create() ;

        File::factory()
            ->state([
                "name" =>  $name = "###123456789"
            ])
            ->for($user)
            ->create() ;

        $response = $this->getJson(
            route("api.v1.filemanager.index" , [
                "name" => $name
            ])
        );

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                "meta" => [
                    "total" => 1 ,
                    "last_page" => 0 ,
                    "current_page" => 0 ,
                    "next_page" => null ,
                ]
            ])
            ->assertJsonStructure([
                "data" => [
                    "*" => [
                        "id",
                        "created_at" ,
                        "updated_at" ,
                        "type",
                        "name",
                        "relpath",
                    ]
                ],
                "meta" => [
                    "total" ,
                    "last_page" ,
                    "current_page" ,
                    "next_page" ,
                ]
            ]);
    }
}

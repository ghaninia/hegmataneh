<?php

namespace Tests\Feature\Controllers\Filemanager;

use App\Kernel\Enums\EnumsFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Response;
use Tests\TestCase;
use App\Models\File;

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
                        "path",
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
                        "path",
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
    public function uploadFileWithoutFolder()
    {
        $user = $this->signIn();
        $response = $this->postJson(
            route("api.v1.filemanager.store" , ["user" => $user]) , [
                "attachments" => [
                    UploadedFile::fake()->create( $filename = "file.png" , 300 ,  $mimeType = "image/png" )
                ]
            ]
        );

        $this->assertDatabaseHas("files" , [
            "user_id" => $user->id ,
            "folder_id" => null ,
            "type" => EnumsFile::TYPE_FILE,
            "name" => $filename,
            "extension" => "png",
            "mime_type" => $mimeType ,
            "driver" => "public"
        ]);

        $this->assertDatabaseCount("files" , 1) ;

        $response
                ->assertStatus(Response::HTTP_OK)
                ->assertJsonStructure([
                    "ok" ,
                    "msg" ,
                    "data" => [
                        "*" => [
                            "id" ,
                            "type",
                            "name",
                            "path",
                            "extension",
                            "mime_type",
                            "size",
                            "driver",
                            "created_at" ,
                            "updated_at"
                        ]
                    ]
                ]);

    }

    /** @test */
    public function uploadMutliFiles()
    {
        $user = $this->signIn() ;
        $response = $this->postJson(
            route("api.v1.filemanager.store" , ["user" => $user]) , [
                "attachments" => [
                    UploadedFile::fake()->create( $filename = "file.png" , 300 ,  $mimeType = "image/png" ) ,
                    UploadedFile::fake()->create( $filename = "file.png" , 300 ,  $mimeType = "image/png" ) ,
                    UploadedFile::fake()->create( $filename = "file.png" , 300 ,  $mimeType = "image/png" ) ,
                    UploadedFile::fake()->create( $filename = "file.png" , 300 ,  $mimeType = "image/png" ) ,
                    UploadedFile::fake()->create( $filename = "file.png" , 300 ,  $mimeType = "image/png" ) ,
                ]
            ]
        );

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(5 , "data");

    }

    /** @test */
    public function uploadFileWithFolder()
    {
        $user = $this->signIn();
        $folder = File::factory()
            ->state([
                "type" => EnumsFile::TYPE_FOLDER ,
                "path" => $basePath = implode(DIRECTORY_SEPARATOR , [
                    $user->id ,
                    "uploads" ,
                ])
            ])
            ->for($user)
            ->create() ;

        $response = $this->postJson(
            route("api.v1.filemanager.store" , [
                "user" => $user ,
                "folder_id" => $folder->id
            ]) , [
                "attachments" => [
                    UploadedFile::fake()->create( $filename = "file.png" , 300 ,  $mimeType = "image/png" ) ,
                ]
            ]
        );

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(1 , "data") ;

        $this->assertDatabaseHas("files" , [
            "folder_id" => $folder->id ,
        ]);
    }
}

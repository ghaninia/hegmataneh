<?php

namespace App\Http\Controllers\Api\File;

use App\Services\File\FileService;
use App\Http\Controllers\Controller;
use App\Http\Requests\File\FileIndex;
use App\Http\Requests\File\FileStore;
use App\Services\Upload\UploadService;
use App\Http\Requests\File\FileDestroy;

class FileController extends Controller
{

    protected $fileService, $uploadService;

    public function __construct(
        UploadService $uploadService,
        FileService $fileService
    ) {
        $this->fileService = $fileService;
        $this->uploadService = $uploadService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FileIndex $request)
    {
        return $this->fileService->list(
            $request->input("path")
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FileStore $request)
    {
        $attachments = $request->file("attachments");

        array_walk($attachments, function ($attachment) {
            $this->uploadService->setFile($attachment)->upload();
        });

        $files = $this->uploadService->dispath();

        return $this->success([
            "msg" => trans("dashboard.success.file.upload", [
                "attribute" => $files->count()
            ])
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  FileDestroy $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(FileDestroy $request)
    {
        $links = $request->input("links");
        $result = $this->fileService->remove($links);

        return
            $this->success([
                "msg" => $result ? trans("dashboard.success.file.delete", [
                    "attribute" => $result
                ]) : trans("dashboard.success.file.without_delete")
            ]);
    }
}

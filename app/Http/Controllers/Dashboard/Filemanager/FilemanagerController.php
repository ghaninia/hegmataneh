<?php

namespace App\Http\Controllers\Dashboard\Filemanager;

use App\Http\Requests\Filemanager\FilemanagerStore;
use App\Models\User;
use App\Http\Resources\File\FileCollection;
use App\Http\Controllers\Controller;
use App\Http\Requests\Filemanager\FilemanagerIndex;
use App\Services\File\FileServiceInterface;
use App\Services\Filemanager\FilemanagerServiceInterface;

class FilemanagerController extends Controller
{

    /**
     * @param FilemanagerServiceInterface $filemanagerService
     * @param FileServiceInterface $fileService
     */
    public function __construct(
        protected FilemanagerServiceInterface $filemanagerService ,
        protected FileServiceInterface $fileService
    ) {
    }

    /**
     * get files and folders
     * @param FilemanagerIndex $request
     * @param User|null $user
     * @return FileCollection
     */
    public function index(FilemanagerIndex $request,User $user = null)
    {
        [
            $result,
            $total ,
            $lastPage,
            $currentPage,
            $nextPage
        ] = $this->filemanagerService->list(
            [
                "user_id"   => $user?->id,
                "folder_id" => $request?->folder_id,
                "name" => $request?->name
            ],
            $request->current_page ?? 0
        );

        return (new FileCollection($result))->additional([
            "meta" => [
                "total" => $total ,
                "last_page" => $lastPage,
                "current_page" => $currentPage,
                "next_page" => $nextPage
            ]
        ]);
    }

    /**
     * uploads files
     * @param FilemanagerStore $request
     * @param User|null $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FilemanagerStore $request , User $user = null)
    {

        $folder = $request->filled("folder_id") ? $this->fileService->find($request->folder_id) : null ;

        $result = $this->filemanagerService->uploads(
            $request->file("attachments") ,
            $folder ,
            $user
        );

        return $this->success([
            "ok" => true ,
            "msg" => trans("dashboard.success.filemanager.upload"),
            "data" => new FileCollection( $result )
        ]);
    }

}

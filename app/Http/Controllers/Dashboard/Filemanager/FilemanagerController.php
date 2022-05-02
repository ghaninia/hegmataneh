<?php

namespace App\Http\Controllers\Dashboard\Filemanager;

use App\Http\Resources\File\FileCollection;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Filemanager\FilemanagerIndex;
use App\Services\Filemanager\FilemanagerServiceInterface;

class FilemanagerController extends Controller
{

    /**
     * @param FilemanagerServiceInterface $filemanagerService
     */
    public function __construct(
        protected FilemanagerServiceInterface $filemanagerService
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
}

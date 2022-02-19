<?php

namespace App\Http\Controllers\Dashboard\File;

use App\Models\File;
use App\Models\User;
use App\Services\File\FileService;
use App\Http\Controllers\Controller;
use App\Http\Requests\File\FileIndex;
use App\Http\Requests\File\NewFolderStore;
use App\Http\Requests\File\FileMoveRequest;
use App\Http\Requests\File\FileUploadStore;
use App\Http\Requests\File\FileRenameUpdate;
use App\Http\Resources\File\FileCollection;

class FileController extends Controller
{

    public function __construct(public FileService $fileService)
    {
    }

    public function index(User $user, File $folder = null, FileIndex $request)
    {
        $filters = array_merge(
            $request->only([
                "name", "extension", "mime_type", "type",
            ]),
            [
                "user" => $user->id,
            ]
        );

        $files = $this->fileService->list(
            $folder,
            $filters,
            $request->only([
                "order_by", "order", "has_recursive"
            ])
        );

        return new FileCollection($files);
    }


    /**
     * create new folder in user's folder
     * @param User $user
     * @param File|null $folder
     * @param NewFolderStore $request
     * @return \Illuminate\Http\Response
     */
    public function newFolder(User $user, File $folder = null, NewFolderStore $request)
    {

        $this->fileService
            ->setUser($user->id)
            ->newFolder(
                $folderName = $request->input('folder_name'),
                $folder
            );

        return $this->success([
            "msg" => trans("dashboard.success.file.create_folder", [
                "attribute" => $folderName
            ])
        ]);
    }

    /**
     * file upload
     * @param File|null $folder
     * @param FileUploadStore $request
     * @return \Illuminate\Http\Response
     */
    public function upload(User $user, File $folder = null, FileUploadStore $request)
    {
        $this->fileService
            ->setUser($user->id)
            ->upload(
                $request->file('attachment'),
                $folder
            );

        return $this->success([
            "msg" => trans("dashboard.success.file.upload")
        ]);
    }

    /**
     * remove file and folder
     * @param User $user
     * @param File $file
     * @return \Illuminate\Http\Response
     */
    public function remove(User $user, File $file, FileMoveRequest $request)
    {
        $this->fileService
            ->setUser($user->id)
            ->remove($file);

        return $this->success([
            "msg" => trans("dashboard.success.file.delete", [
                "attribute" => $file->name
            ])
        ]);
    }

    public function rename(User $user, File $file, FileRenameUpdate $request)
    {

        $this->fileService
            ->setUser($user->id)
            ->rename(
                $file,
                $newName = $request->input('new_name')
            );

        return $this->success([
            "msg" => trans("dashboard.success.file.rename", [
                "name" => $file->name,
                "newName" => $newName
            ])
        ]);
    }


    public function move(User $user, File $file, File $folder = null)
    {
        $this->fileService
            ->setUser($user->id)
            ->move(
                $file,
                $folder
            );

        return $this->success([
            "msg" => trans("dashboard.success.file.move", [
                "name" => $file->name,
                "destination" => $folder->name ?? trans("dashboard.fields.main_root")
            ])
        ]);
    }
}

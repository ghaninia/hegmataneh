<?php

namespace App\Services\File;

use App\Services\Upload\UploadService;
use App\Services\File\FileServiceInterface;

class FileService implements FileServiceInterface
{
    protected $uploadService;

    /**
     * @param UploadService $uploadService
     */
    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    /**
     * get all uploads list
     * @param ?string $basePath
     * @return array
     */
    public function list(?string $basePath = null, array $includes = [])
    {

        $path = $this->uploadService->trimSeparator(
            $basePath ?? $this->uploadService->basePath()
        );

        $path = $this->uploadService->addSeparator(
            $path
        );

        foreach (glob($path . "*") as $file) {
            $includes[] = array_merge(
                [
                    "is_dir" => $isDir = is_dir($file),
                    "size" => !$isDir ? filesize($file) : 0,
                    "name" => basename($file),
                    "link" => $this->uploadService->link($file),
                    "time" => $this->uploadService->time($file),
                    "perm" => $this->uploadService->per($file),
                ],
                $isDir ? ["childrens" => $this->list($file)] : []
            );
        }

        return $includes;
    }
}

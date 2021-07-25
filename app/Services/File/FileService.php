<?php

namespace App\Services\File;

use App\Services\Upload\UploadService;
use Illuminate\Support\Facades\Storage;
use App\Repositories\File\FileRepository;
use App\Services\File\FileServiceInterface;

class FileService implements FileServiceInterface
{
    protected $uploadService, $fileRepo;

    /**
     * @param UploadService $uploadService
     */
    public function __construct(
        UploadService $uploadService,
        FileRepository $fileRepo
    ) {
        $this->uploadService = $uploadService;
    }

    /**
     * get all uploads list
     * @param ?string $baseDirectiory
     * @param ?string $basePath
     * @return array
     */
    public function list(?string $baseDirectiory = null, ?string $basePath = null)
    {

        $path = $this->uploadService->trimSeparator(
            $basePath ?? $this->uploadService->basePath()
        );

        $path = $this->uploadService->addSeparator(
            $path
        );

        $baseDirectiory = $this->uploadService->trimSeparator($baseDirectiory);

        $path = !!$baseDirectiory ? $this->uploadService->addSeparator(
            $path . $baseDirectiory
        ) : $path;

        $includes = [];

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
                $isDir ? ["childrens" => $this->list(null, $file)] : []
            );
        }

        return $includes;
    }

    /**
     * delete files
     * @param string $link
     * @return boolean
     */
    public function remove(...$links): bool
    {
        $result = [];

        array_walk($links, function ($link) use (&$result) {
            $result[] = $this->uploadService->delete($link);
        });

        return count(
            array_filter($result, fn ($item) => $item)
        );
    }
}

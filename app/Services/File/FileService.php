<?php

namespace App\Services\File;

use App\Core\Interfaces\FileableInterface;
use App\Services\Upload\UploadService;
use App\Repositories\File\FileRepository;
use App\Repositories\Fileable\FileableRepository;
use App\Services\File\FileServiceInterface;

class FileService implements FileServiceInterface
{

    public function __construct(
        protected UploadService $uploadService,
        protected FileableRepository $fileableRepo,
        protected FileRepository $fileRepo
    ) {
    }

    /**
     * 
     * @param FileableInterface $fileable
     * @param array|int|null $files
     * @param string $usage
     */
    public function fileables(FileableInterface $fileable, array|int|null $files, string $usage)
    {

        $fileable->files()->where("usage", $usage)->each->delete();

        $files = is_int($files) ? [$files] : $files;

        if (is_null($files)) return;

        $files =
            array_map(fn ($file) => [
                "file_id" => $file,
                "fileable_type" => $fileable->getMorphClass(),
                "fileable_id" => $fileable->id,
                "usage" => $usage,
            ], $files);


        $this->fileableRepo->createMultiple($files);
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
     * @param array $link
     * @return boolean
     */
    public function remove(array $links): bool
    {
        $paths = $result = [];

        array_walk($links, function ($link) use (&$paths, &$result) {
            $result[] = $this->uploadService->delete(
                $paths[] = $this->uploadService->cleanFormatAddress($link, true)
            );
        });

        $this->fileRepo->query()
            ->whereIn("path", $paths)
            ->delete();

        return count(
            array_filter($result, fn ($item) => $item)
        );
    }
}

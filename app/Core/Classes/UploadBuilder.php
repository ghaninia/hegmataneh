<?php

namespace App\Core\Classes;

use Illuminate\Support\Str;
use App\Core\Enums\EnumsFile;
use Illuminate\Support\Facades\Storage;

abstract class UploadBuilder
{
    private $basePath = "uploads";
    public $user, $file, $usage;

    /**
     * upload file to storage
     * @return array
     */
    public function put(): array
    {
        return [
            "path" => Storage::putFileAs(
                $this->basePathUpload(),
                $this->file,
                $this->generateName()
            ),
            "type" => $this->typePath(),
            "size" =>  $this->fileSize(),
            "usage" => $this->usage,
        ];
    }

    /**
     * trim separator path direction
     * @param ?string $path
     * @return ?string
     */
    public function trimSeparator(?string $path = NULL): ?string
    {
        return trim($path, DIRECTORY_SEPARATOR);
    }

    /**
     * add separator in path
     * @param string $path
     * @return string
     */
    public function addSeparator(?string $path = null): ?string
    {
        return !!$this->trimSeparator($path) ?
            sprintf("%s%s", $path, DIRECTORY_SEPARATOR) :
            NULL;
    }

    /**
     * get per file
     * @param string $path
     * @return string
     */
    public function per(string $path): string
    {
        return substr(sprintf('%o', fileperms($path)), -4);
    }

    /**
     * get create time file
     * @param string $path
     * @return string
     */
    public function time(string $path): string
    {
        return fileatime($path);
    }



    /**
     * delete file
     * @param string $path
     * @return boolean
     */
    public function delete(string $path): bool
    {
        return Storage::delete($path);
    }

    /**
     * @param $path
     * @return string
     */
    public function link($path): string
    {
        $trimPath = $this->trimSeparator(Storage::path(DIRECTORY_SEPARATOR));
        $path = str_replace($trimPath, "", $path);
        $path = $this->trimSeparator($path);
        return Storage::url($path);
    }

    /**
     * generate base path for upload
     * @return string
     */
    private function basePathUpload(): string
    {
        $path  = $this->basePath();
        $path .= $this->typePath();
        return $path;
    }

    /**
     * get base path
     * @return string
     */
    public function basePath(): string
    {
        $userPath = $this->trimSeparator($this->userPath());
        $path  = $this->addSeparator($this->basePath);
        $path .= !!$userPath ? $this->addSeparator($userPath) : NULL;

        return $this->trimSeparator(Storage::path($path));
    }

    /**
     * get user directory
     * @return string
     */
    public function userPath(): ?string
    {
        return NULL;
    }

    /**
     * get type file
     * @return string
     */
    private function typePath(): string
    {
        return in_array($this->file->getMimeType(), EnumsFile::MIME_TYPE_FILE) ?
            EnumsFile::TYPE_FILE :
            EnumsFile::TYPE_IMAGE;
    }

    /**
     * generate uuid
     * @return string
     */
    private function generateName(): string
    {
        $extension = $this->file->getClientOriginalExtension();
        return sprintf("%s.%s", Str::uuid(), $extension);
    }

    /**
     * get file size
     * @return integer
     */
    private function fileSize(): int
    {
        return $this->file->getSize();
    }
}

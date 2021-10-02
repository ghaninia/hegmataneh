<?php

namespace App\Core\Classes;

use Illuminate\Support\Str;
use App\Core\Enums\EnumsFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

abstract class UploadBuilder
{
    private const SALT = "_*_._*_._*_";
    private string $basePath = "uploads";
    public $user, $file, $usage;

    /**
     * upload file to storage
     * @return array
     */
    public function put(): array
    {
        return [
            "path" => Storage::putFileAs(
                $this->cleanFormatAddress(
                    $this->basePathUpload()
                ),
                $this->file,
                $this->generateName()
            ),
            "type" => $this->fileType(),
            "size" =>  $this->fileSize()
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
     * delete file
     * @param string $path
     * @return boolean
     */
    public function delete(string $path): bool
    {
        if (!Storage::exists($path))
            return false;

        return
            is_dir($path = Storage::path($path)) ?
            File::deleteDirectory($path) :
            File::delete($path);
    }

    /**
     * remove address relative path
     * @param string $path
     * @param bool $isLinkAddress
     * @return string
     */
    public function cleanFormatAddress(string $path, bool $isLinkAddress = false): string
    {
        $trimPath = $this->trimSeparator(
            $isLinkAddress ? Storage::url(DIRECTORY_SEPARATOR) : Storage::path(DIRECTORY_SEPARATOR)
        );
        $path = str_replace($trimPath, "", $path);
        $path = $this->trimSeparator($path);
        return str_replace(DIRECTORY_SEPARATOR, "/", $path);
    }

    /**
     * get link address
     * @param $path
     * @return string
     */
    public function link($path): string
    {
        return Storage::url(
            $this->cleanFormatAddress($path)
        );
    }

    /**
     * generate base path for upload
     * @return string
     */
    private function basePathUpload(): string
    {
        $path  = $this->basePath();
        $path .= $this->fileType();
        return $path;
    }

    /**
     * get base path
     * @return string
     */
    public function basePath(): string
    {

        $userPath = $this->userPath();

        ### append salt :)
        $userPath = md5(self::SALT . $userPath);

        $userPath = $this->trimSeparator($userPath);

        $path  = $this->addSeparator($this->basePath);

        $path .= !!$userPath ? $this->addSeparator($userPath) : NULL;

        return Storage::path($path);
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
    private function fileType(): string
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
}

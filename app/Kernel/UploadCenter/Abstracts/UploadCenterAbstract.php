<?php

namespace App\Kernel\UploadCenter\Abstracts;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use App\Kernel\UploadCenter\Classes\FileActionCenter;

abstract class UploadCenterAbstract extends FileActionCenter
{

    const BASE_PATH = "uploads";

    private User $user;
    private string $type;
    private string $tag;
    private string $originalName;
    private string $originalMimeType;
    private string $originalExtension;
    private UploadedFile|string  $file;

    abstract public function servicePathName($name = null): string;

    abstract public function serviceGuardName($name = null): string;


    /**
     * @param UploadedFile|string $file
     */
    public function setFile(UploadedFile|string $file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): SELF
    {
        $this->user = $user;

        return $this;
    }


    /**
     * @param string $tag
     */
    public function setTag(string $tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param string $originalExtension
     */
    public function setOriginalExtension(string $originalExtension)
    {
        $this->originalExtension = $originalExtension;

        return $this;
    }

    /**
     * @param string $originalName
     */
    public function setOriginalName(string $originalName)
    {
        $this->originalName = $originalName;

        return $this;
    }

    /**
     * @param string $originalMimeType
     */
    public function setOriginalMimeType(string $originalMimeType)
    {
        $this->originalMimeType = $originalMimeType;

        return $this;
    }

    /**
     * ساخت تولید تاریخ
     * @return Verta
     */
    public function date()
    {
        return verta();
    }

    /**
     * upload file to server and save to database
     * @param UploadedFile $file
     * @param string|null $parentDirectoryId
     */
    public function append(): self
    {

        parent::store(
            $this->file,
            $uploadPath = $this->getUploadPath(),
            $fileName = $this->generateFileName()
        );

        static::$dataUploads[] = [
            "disk" => $this->disk,
            "user_id"  => $this->user->id ?? NULL,
            "type" =>  $this->getType(),
            "name" => $this->getClientOriginalName(),
            "path" => implode(DIRECTORY_SEPARATOR, [$uploadPath, $fileName]),
            "tag" => $this->tag ?? NULL,
            "extension" => $this->getClientOriginalExtension(),
            "mime_type" => $this->getClientMimeType(),
            "size" => $this->getSize(),
        ];

        return $this;
    }



    /**
     * get user base folder
     * @return string
     */
    private function getUploadPath(): string
    {

        $basePath[] = SELF::BASE_PATH;

        $basePath[] = $this->date()->format("%Y");

        $basePath[] = $this->serviceGuardName();

        if (isset($this->user))
            $basePath[] = strval($this->user->id);

        $basePath[] = $this->date()->format("%B");

        $basePath[] = $this->servicePathName();

        $path = implode(DIRECTORY_SEPARATOR, $basePath);

        $this->createPathIfNotExists($path);

        return $path;
    }

    /**
     * create new path if not exists
     * @return void
     */
    public function createPathIfNotExists(string $path): void
    {
        $this->makeDirectory($path);
    }

    /**
     * generate new name for file
     */
    private function generateFileName()
    {
        return sprintf(
            "%s-%s.%s",
            $this->date()->format("%Y-%m-%d"),
            Str::random(50),
            $this->getClientOriginalExtension()
        );
    }

    /**
     * @return string
     */
    private function getClientOriginalExtension(): string
    {
        return is_string($this->file) ? $this->originalExtension : $this->file->getClientOriginalExtension();
    }

    /**
     * @return string
     */
    private function getClientOriginalName(): string
    {
        return is_string($this->file) ?
            sprintf("%s.%s", $this->originalName ?? Str::random(10), $this->originalExtension) :
            $this->file->getClientOriginalName();
    }

    /**
     * @return int
     */
    private function getSize(): int
    {
        return is_string($this->file) ? 0 : $this->file->getSize();
    }

    /**
     * @return string
     */
    private function getClientMimeType(): ?string
    {
        return is_string($this->file) ?
            $this->originalMimeType ?? NULL :
            $this->file->getClientMimeType();
    }

    /**
     * @return string|null
     */

    /**
     * @return string
     */
    public function getType(): string
    {
        if (isset($this->type)) return $this->type;

        $fileMime = $this->file->getMimeType() ;

        foreach (EnumsFile::mimes() as $mime) {
            $type = match (true) {
                in_array($fileMime, EnumsFile::MIME_TYPE_PICITRE) => EnumsFile::TYPE_IMAGE,
                in_array($fileMime, EnumsFile::MIME_TYPE_VOICE) => EnumsFile::TYPE_VOICE,
                in_array($fileMime, EnumsFile::MIME_TYPE_DOCUMENT) => EnumsFile::TYPE_DOCUMENT,
            };
        }

        return $type ;
    }
}

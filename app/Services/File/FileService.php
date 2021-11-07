<?php

namespace App\Services\File;

use App\Models\File;
use App\Models\User;
use Illuminate\Support\Str;
use App\Core\Enums\EnumsFile;
use App\Core\Enums\EnumsSystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Services\File\FileServiceInterface;

class FileService implements FileServiceInterface
{
    protected const SLUG = ".-_.-_.-_.";
    protected const BASE_PATH = "uploads";
    protected $basePath, $userId;

    /**
     * set user 
     * @param int $userId
     * @return self 
     */
    public function setUser(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * get file path
     * @param string $fileID 
     * @param string $ext 
     * @return string 
     */
    public function link(string $fileID, string $ext): string
    {
        $url = Storage::url(
            sprintf(
                "%s%s%s",
                $this->getBasePath(),
                DIRECTORY_SEPARATOR,
                $this->getFileName($fileID, $ext)
            )
        );

        return str_replace(DIRECTORY_SEPARATOR, "/", $url);
    }

    /**
     * get file path
     * @param array $filters 
     * @param array $options 
     */
    public function list(File $baseDir = null, array $filters, array $options = [])
    {

        $isRecursive = $options["has_recursive"] ?? FALSE;

        $orderBy = $options["order_by"] ?? "type";
        $order = $options["order"] ?? EnumsSystem::ORDER_ASC;

        return
            File::query()
            ->filterBy($filters)
            ->withCount([
                "fileables"
            ])
            ->when(
                $baseDir,
                fn ($query) => $query->where("file_id", $baseDir->id),
                fn ($query) => $query->whereNull("file_id")
            )
            ->when(
                $isRecursive,
                fn ($query) => $query->with("childrens")
            )
            ->orderBy($orderBy, $order)
            ->get();
    }

    /**
     * get user base folder
     * @return string 
     */
    private function getBasePath(): string
    {

        if (is_null($this->basePath)) {
            $path = sprintf("%s%s%s", self::SLUG, $this->userId, self::SLUG);
            $this->basePath = sprintf("%s%s%s", self::BASE_PATH, DIRECTORY_SEPARATOR, md5($path));
        }

        return $this->basePath;
    }

    /**
     * generate id for file
     * @return string
     */
    private function generateID(): string
    {
        return Str::uuid()->toString();
    }

    /**
     * create new folder
     * @param string $name
     * @param string|null $parentFolder
     * @return void
     */
    public function newFolder(string $name, File $parentFolder = null): void
    {
        File::updateOrCreate([
            "id" => $this->generateID(),
            "type" => EnumsFile::TYPE_FOLDER,
            "user_id" => $this->userId,
            "file_id" => $parentFolder?->id,
            "name" => $name,
        ], []);
    }

    /**
     * user directory exists ?
     * 
     * @return bool 
     */
    private function userDirExists(): bool
    {
        return Storage::exists($this->getBasePath());
    }

    /**
     * create new folder for user
     * 
     * @return void 
     */
    private function userDirCreate(): void
    {
        Storage::makeDirectory($this->getBasePath());
    }

    /**
     * create new directory when user dir not exists
     * 
     * @return void 
     */
    private function whenUserDirNotExistsCreateNew(): void
    {
        if (!$this->userDirExists())
            $this->userDirCreate();
    }

    /**
     * upload file to server and save to database
     * @param UploadedFile $file
     * @param string|null $parentDirectoryId
     */
    public function upload(UploadedFile $file, File $parentDir = null): void
    {

        $this->whenUserDirNotExistsCreateNew();

        File::create([
            "id" => $fileID = $this->generateID(),
            "file_id" => $parentDir?->id,
            "user_id" => $this->userId,
            "type" => EnumsFile::TYPE_FILE,
            "name" => $file->getClientOriginalName(),
            "extension" => $ext = $file->getClientOriginalExtension(),
            "mime_type" => $file->getClientMimeType(),
            "size" => $file->getSize(),
        ]);

        $file->storeAs(
            $this->getBasePath(),
            $this->getFileName($fileID, $ext)
        );
    }

    /**
     * generate file name
     * @param string $fileID
     * @param string $ext
     * 
     * @return string
     */
    private function getFileName(string $fileID, string $ext)
    {
        return sprintf("%s.%s", $fileID, $ext);
    }

    /**
     * file exists in user directory ? if exists delete it
     * @param File $file
     * @return bool 
     */
    private function whenFileExistsInUserDirDeleteIt(File $file): bool
    {
        $filePath = sprintf("%s%s%s", $this->getBasePath(), DIRECTORY_SEPARATOR, $file->path);

        return Storage::exists($filePath) ? Storage::delete($filePath) : false;
    }

    /**
     * delete file from server
     * @param File $file
     * @return bool 
     */
    private function recursiveDelete(File $file): void
    {
        $this->whenFileExistsInUserDirDeleteIt($file);

        if ($file->type == EnumsFile::TYPE_FOLDER) {
            foreach ($file->childrens as $file) {
                $this->recursiveDelete($file);
            }
        }
    }

    /**
     * delete file or folder
     * @param File $file
     * @return boolean
     */
    public function remove(File $file): bool
    {
        $this->recursiveDelete($file);
        return $file->delete();
    }

    /**
     * rename file or folder
     * @return boolean 
     */
    public function rename(File $file, string $newName)
    {
        return $file->update(["name" => $newName]);
    }

    /**
     * move file or folder
     * @param File $file
     * @param File $parentFolder
     * @return boolean
     */
    public function move(File $file, File $parentFolder = null): bool
    {
        return $file->update(["file_id" => $parentFolder?->id]);
    }
}

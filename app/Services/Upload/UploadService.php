<?php

namespace App\Services\Upload;

use App\Models\File;
use App\Models\User;
use Illuminate\Support\Collection;
use App\Core\Classes\UploadBuilder;
use App\Repositories\File\FileRepository;
use App\Services\Authunticate\AuthService;
use App\Services\Upload\UploadServiceInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadService extends UploadBuilder implements UploadServiceInterface
{
    public $user, $file, $fileRepo, $authService;

    static array $uploadFiles  = [];

    public function __construct(FileRepository $fileRepo, AuthService $authService)
    {
        $this->fileRepo = $fileRepo;
        $this->authService = $authService;
    }

    /**
     * @param UploadedFile $file
     * @param string $usage
     * @param User $user
     * @return self
     */
    public function setParameters(
        UploadedFile $file,
        string $usage,
        ?User $user = null
    ) {
        $this->file = $file;
        $this->usage = $usage;
        $this->user = $user;
        return $this;
    }

    /**
     * get user
     * @return ?User
     */
    public function user(): ?User
    {
        return $this->user ?? $this->authService->user() ?? null;
    }

    /**
     * complete upload file
     * @return void
     */
    public function upload(): void
    {
        static::$uploadFiles[] = array_merge(
            ["user_id" => optional($user = $this->user())->id],
            $this->put(
                $this->file,
                $this->usage,
                $user
            )
        );
    }

    /**
     * dispatch upload file
     * @return Collection
     */
    public function dispath(): Collection
    {
        return
            $this->fileRepo->createMultiple(
                static::$uploadFiles
            );
    }

    /**
     * complete delete file
     * @param File $file
     * @return boolean
     */
    public function destroy(File $file): bool
    {
        @$this->delete($file->path);
        return $file->delete();
    }

    /**
     * get user directory
     * @return string
     */
    public function userPath(): ?string
    {
        $user = $this->user();
        return !!$user ? $user->id  : NULL;
    }
}

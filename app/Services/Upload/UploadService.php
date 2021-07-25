<?php

namespace App\Services\Upload;

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
     * setter file
     * @param UploadedFile $file
     * @return self
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * setter user
     * @param User $user
     * @return self
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this ;
    }

    /**
     * getter user
     * @return ?User
     */
    public function getUser(): ?User
    {
        return $this->user ?? $this->authService->user() ?? null;
    }

    /**
     * complete upload file
     * @return void
     */
    public function upload(): void
    {
        $user = $this->getUser() ;
        static::$uploadFiles[] = array_merge(
            ["user_id" => $user->id ?? null ],
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
     * get user directory
     * @return string
     */
    public function userPath(): ?string
    {
        $user = $this->getUser();
        return !!$user ? $user->id  : NULL;
    }


    public function accessFile($link)
    {
        $userBasePath = $this->cleanFormatAddress(
            $this->basePath()
        );

        $linkBasePath = $this->cleanFormatAddress(
            $link,
            true
        );

        return str_starts_with($linkBasePath, $userBasePath);
    }
}

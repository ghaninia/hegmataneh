<?php

namespace App\Services\Filemanager;

use App\Kernel\Filemanager\Drivers\PublicDriver;
use App\Kernel\Filemanager\Interfaces\FileInterface;
use App\Kernel\Lazyloading\Lazyloading;
use App\Kernel\Filemanager\UploadFile;
use App\Models\File;
use App\Models\User;

class FilemanagerService implements FilemanagerServiceInterface
{
    /**
     * Get a list of folders and files
     * @param array $filters
     * @param int $currentPage
     * @return array
     */
    public function list(array $filters, int $currentPage = 0)
    {
        $query = File::query()->filterBy($filters);
        return (new Lazyloading)->query($query)->make($currentPage) ;
    }

    /**
     * uploads multiple files
     * @param array $attachments
     * @param FileInterface|null $folder
     * @param User|null $user
     * @return false|\Illuminate\Support\Collection
     */
    public function uploads( array $attachments = [] , FileInterface $folder = null , User $user = null )
    {
        if (empty($attachments)) return false ;

        $instanceUpload = (new UploadFile(new PublicDriver()))->user($user)->basePath($folder) ;

        array_walk( $attachments , fn($attachment) => $instanceUpload->file($attachment)->add() );

        return $instanceUpload->upload() ;
    }

}

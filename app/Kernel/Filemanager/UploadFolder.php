<?php

namespace App\Kernel\Filemanager;

use App\Kernel\Enums\EnumsFile;
use App\Kernel\Filemanager\Abstracts\UploadAbstract;

class UploadFolder extends UploadAbstract
{

    /**
     * make new directory
     * @param string $folderName
     * @return \Illuminate\Support\Collection
     */
    public function make(string $folderName)
    {
        return $this->insert([
            [
                "driver" => $this->driver->disk() ,
                "user_id" => $this?->user?->id ,
                "folder_id" => $this?->baseFolder?->id ,
                "type" => EnumsFile::TYPE_FOLDER ,
                "path" => $this->generateRelativePath() ,
                "name" => $folderName ,
                "extension" => NULL ,
                "mime_type" => NULL ,
                "size" => NULL ,
            ]
        ]);
    }

    /**
     * get relative path
     * @return string
     */
    public function generateRelativePath(): string
    {
        if (isset($this->basePath)){
            $path = explode(DIRECTORY_SEPARATOR , $this->basePath ) ;
        } elseif (isset($this->user)){
            $path[] = $this->user->id ;
        }

        $path[] = uniqid() ;

        return implode("/" , $path) ;
    }
}

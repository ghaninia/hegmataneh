<?php

namespace App\Kernel\Filemanager;

use App\Kernel\Enums\EnumsFile;
use Illuminate\Support\Facades\Storage;
use App\Kernel\Filemanager\Abstracts\UploadAbstract;

class UploadFile extends UploadAbstract
{

    private array $files = [] ;

    /**
     * append file
     * @return $this
     */
    public function add()
    {

        $this->files[] = [
            "driver" => $this->driver->disk() ,
            "user_id" => $this?->user?->id ,
            "folder_id" => $this?->baseFolder?->id ,
            "file" => $this->file ,
            "type" => EnumsFile::TYPE_FILE ,
            "path" => $this->generateRelativePath() ,
            "name" => $this->getName() ,
            "extension" => $this->getExtension() ,
            "mime_type" => $this->getMimeType() ,
            "size" => $this->getSize() ,
        ];

        return $this;
    }

    /**
     * upload files and store files in storage
     * @return \Illuminate\Support\Collection
     */
    public function upload()
    {
        array_walk(
            $this->files ,
            function($file) {
                $path = pathinfo($file["path"] , PATHINFO_DIRNAME) ;
                $name = basename($file["path"]) ;
                Storage::disk($file["driver"])->putFileAs($path , $file["file"] , $name);
            }
        );

        return $this->insert($this->files);
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->file->getSize() ?? 0 ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->file->getClientOriginalName() ;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->file->getClientOriginalExtension() ;
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->file->getClientMimeType() ;
    }

    /**
     * @return string
     */
    public function generateRelativePath() : string
    {

        if (isset($this->basePath)){
            $path = explode(DIRECTORY_SEPARATOR , $this->basePath ) ;
        } elseif (isset($this->user)){
            $path[] = $this->user->id ;
        }

        $path[] = sprintf( "%s.%s" , uniqid() , $this->getExtension() ) ;

        return implode("/" , $path) ;
    }
}

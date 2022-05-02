<?php

namespace App\Kernel\Filemanager;

use App\Kernel\Enums\EnumsFile;
use Illuminate\Support\Facades\Storage;
use App\Kernel\Filemanager\Abstracts\UploadAbstract;

class UploadFile extends UploadAbstract
{

    private array $files = [] ;

    /**
     * @return $this
     */
    public function add()
    {

        $this->files[] = [
            "user_id" => $this?->user?->id ,
            "folder_id" => $this?->baseFolder?->id ,
            "file" => $this->file ,
            "type" => EnumsFile::TYPE_FILE ,
            "relpath" => $this->generateRelativePath() ,
            "name" => $this->getName() ,
            "extension" => $this->getExtension() ,
            "mime_type" => $this->getMimeType() ,
            "size" => $this->getSize() ,
        ];

        return $this;
    }

    /**
     * @param bool $pull
     */
    public function upload()
    {
        array_walk(
            $this->files ,
            fn($file) => Storage::disk($file["disk"])->put( $file["path"] , $file["file"])
        );
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
    public function generateRelativePath()
    {
        if (isset($this->user))
            $path[] = $this->user->id ;

        if (isset($this->path))
            $path[] = $this->path ;

        $path[] = sprintf( "%s.%s" , uniqid() , $this->getExtension() ) ;

        return implode(DIRECTORY_SEPARATOR , $path) ;
    }
}

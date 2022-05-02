<?php

namespace App\Kernel\Filemanager\Abstracts;

use Illuminate\Http\UploadedFile;
use App\Kernel\Filemanager\Interfaces\FileInterface;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Kernel\Filemanager\Interfaces\UploadDriverInterface;
use Illuminate\Support\Facades\Storage;

class UploadAbstract extends UploadModel
{

    protected ?FileInterface $baseFolder = null;
    protected ?Authenticatable $user = null ;
    protected ?UploadedFile $file = null;
    protected ?string $basePath = null;

    /**
     * @param UploadDriverInterface $driver
     */
    public function __construct(
        protected UploadDriverInterface $driver
    ){}

    /**
     * @param null $user
     * @return $this
     */
    public function user($user = null)
    {
        $this->user = $user ;
        return $this;
    }

    /**
     * @param $path
     * @return $this
     */
    public function basePath($folder = null )
    {
        $this->baseFolder = $folder ;
        $this->basePath = $folder?->path ;

        return $this ;
    }

    /**
     * @param UploadedFile $file
     * @return $this
     */
    public function file(UploadedFile $file)
    {
        $this->file = $file;
        return $this ;
    }

}

<?php

namespace App\Kernel\Filemanager\Abstracts;

use App\Kernel\Filemanager\Interfaces\UploadDriverInterface;
use Illuminate\Foundation\Auth\User as Authenticatable;
use http\Exception\InvalidArgumentException;
use Illuminate\Http\UploadedFile;

class UploadAbstract
{

    protected ?UploadDriverInterface $driver = null ;
    protected ?Authenticatable $user = null ;
    protected ?string $path = null;
    protected UploadedFile $file ;

    /**
     * @param null $driver
     * @return $this
     */
    public function driver($driver)
    {
        $this->driver = $driver;
        return $this;
    }

    /**
     * @param null $user
     * @return $this
     */
    public function user($user)
    {
        $this->user = $user ;
        return $this;
    }

    /**
     * @param $path
     * @return $this
     */
    public function path($path)
    {

        if (preg_match("/\\\.|\/\./" , $path )){
            throw new InvalidArgumentException() ;
        }

        $path = str_replace( "/" , DIRECTORY_SEPARATOR , $path ) ;
        $path = str_replace( "\\" , DIRECTORY_SEPARATOR , $path ) ;
        $this->path = trim($path , DIRECTORY_SEPARATOR) ;

        return $this ;
    }

    /**
     * @param UploadedFile $file
     * @return UploadedFile
     */
    public function file(UploadedFile $file)
    {
        $this->file = $file;
        return $file ;
    }
}

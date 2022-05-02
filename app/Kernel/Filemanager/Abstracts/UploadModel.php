<?php

namespace App\Kernel\Filemanager\Abstracts;
use App\Services\File\FileServiceInterface;

abstract class UploadModel
{
    /**
     * save multiple files
     * @param $values
     * @return \Illuminate\Support\Collection
     */
    public function insert($values)
    {
        $collect = collect() ;
        array_walk($values ,function($data) use (&$collect){
             $collect->push(
                 app(FileServiceInterface::class)->create($data)
             );
        });
        return $collect ;
    }
}

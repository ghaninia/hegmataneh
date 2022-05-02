<?php

namespace App\Services\File;

use App\Kernel\Filemanager\Interfaces\FileInterface;

interface FileServiceInterface
{
    public function find(string $uuid , string $type = null ) : ?FileInterface ;
    public function create(array $data) : FileInterface ;
}

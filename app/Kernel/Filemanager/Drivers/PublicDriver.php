<?php

namespace App\Kernel\Filemanager\Drivers;

use App\Kernel\Filemanager\Interfaces\UploadDriverInterface;

class PublicDriver implements UploadDriverInterface
{
    public function disk(): string
    {
        return "public";
    }
}

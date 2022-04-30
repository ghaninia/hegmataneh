<?php

namespace App\Kernel\Filemanager\Drivers;

use App\Enums\EnumsFile;
use App\Kernel\Filemanager\Interfaces\UploadDriverInterface;

class S3Driver implements UploadDriverInterface
{
    public function disk(): string
    {
        return "s3";
    }
}

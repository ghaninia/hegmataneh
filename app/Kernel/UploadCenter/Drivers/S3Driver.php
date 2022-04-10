<?php

namespace App\Kernel\UploadCenter\Drivers;

use App\Enums\EnumsFile;
use App\Kernel\UploadCenter\Interfaces\UploadDriverInterface;

class S3Driver implements UploadDriverInterface
{
    public function disk(): string
    {
        return EnumsFile::DRIVER_S3;
    }
}

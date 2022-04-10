<?php

namespace App\Kernel\UploadCenter\Drivers;

use App\Enums\EnumsFile;
use App\Kernel\UploadCenter\Interfaces\UploadDriverInterface;

class PublicDriver implements UploadDriverInterface
{
    public function disk(): string
    {
        return EnumsFile::DRIVER_PUBLIC;
    }
}

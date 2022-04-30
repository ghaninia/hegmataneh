<?php

namespace App\Kernel\Filemanager\Interfaces;

interface UploadDriverInterface
{
    public function disk(): string;
}

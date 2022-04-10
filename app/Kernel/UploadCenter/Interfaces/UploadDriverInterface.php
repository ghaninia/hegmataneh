<?php

namespace App\Kernel\UploadCenter\Interfaces;

interface UploadDriverInterface
{
    public function disk(): string;
}

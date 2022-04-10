<?php

namespace App\Kernel\UploadCenter\Interfaces;

use App\Kernel\Model\Interfaces\ModelableInterface;

interface FileableInterface extends ModelableInterface
{
    public function files();
}

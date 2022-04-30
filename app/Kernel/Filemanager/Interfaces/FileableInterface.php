<?php

namespace App\Kernel\Filemanager\Interfaces;

use App\Kernel\Model\Interfaces\ModelableInterface;

interface FileableInterface extends ModelableInterface
{
    public function files();
}

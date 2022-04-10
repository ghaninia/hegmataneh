<?php

namespace App\Kernel\Tag\Interfaces;

use App\Kernel\Model\Interfaces\ModelableInterface;

interface TagableInterface extends ModelableInterface
{
    public function tags();
}

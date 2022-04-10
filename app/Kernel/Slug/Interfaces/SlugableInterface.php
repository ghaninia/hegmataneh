<?php

namespace App\Kernel\Slug\Interfaces;

use App\Kernel\Model\Interfaces\ModelableInterface;

interface SlugableInterface extends ModelableInterface
{
    public function slugs();
}

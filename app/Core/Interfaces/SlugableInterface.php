<?php

namespace App\Core\Interfaces;

interface SlugableInterface extends ModelableInterface
{
    public function slugs();
}

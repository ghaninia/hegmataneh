<?php

namespace App\Core\Interfaces;

interface SlugableInterface
{
    public function slugs();
    public function getMorphClass() ;
}

<?php

namespace App\Services\Slug;


use App\Kernel\Slug\Interfaces\SlugableInterface;

interface SlugServiceInterface
{
    public function sync(SlugableInterface $slugable, array $languages = []): void;
}

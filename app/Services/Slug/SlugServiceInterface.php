<?php

namespace App\Services\Slug;

use App\Core\Interfaces\SlugableInterface;

interface SlugServiceInterface
{
    public function sync(SlugableInterface $slugable, array $languages = []): void;
}

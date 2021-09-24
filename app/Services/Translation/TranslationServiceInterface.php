<?php

namespace App\Services\Translation;

use App\Core\Interfaces\TranslationableInterface;

interface TranslationServiceInterface
{
    public function sync(TranslationableInterface $model, array $translations): void ;
}

<?php

namespace App\Services\Translation;


use App\Kernel\Translation\Interfaces\TranslationableInterface;

interface TranslationServiceInterface
{
    public function sync(TranslationableInterface $model, array $translations): void ;
}

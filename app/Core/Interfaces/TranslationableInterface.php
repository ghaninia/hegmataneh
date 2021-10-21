<?php

namespace App\Core\Interfaces;

/**
 * @property public translationable
 */
interface TranslationableInterface extends ModelableInterface
{
    public function translations() ;
}

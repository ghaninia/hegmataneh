<?php

namespace App\Core\Interfaces;

/**
 * @property public translationable
 */
interface TranslationableInterface 
{
    public function translations() ;
    public function getMorphClass() ;
}

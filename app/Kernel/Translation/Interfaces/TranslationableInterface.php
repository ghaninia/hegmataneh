<?php

namespace App\Kernel\Translation\Interfaces;

use App\Kernel\Model\Interfaces\ModelableInterface;

/**
 * @property public translationable
 */
interface TranslationableInterface extends ModelableInterface
{
    public function translations() ;
}

<?php

namespace App\Core\Traits;

use App\Models\Translation;

trait HasTranslationTrait
{
    public function translations()
    {
        return $this
            ->morphMany(Translation::class, "translationable");
    }
}

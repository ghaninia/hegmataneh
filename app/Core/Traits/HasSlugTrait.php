<?php

namespace App\Core\Traits;

use App\Models\Slug;

trait HasSlugTrait
{
    public function slugs()
    {
        return $this
            ->morphMany(Slug::class, "slugable");
    }
}

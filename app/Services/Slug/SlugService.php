<?php

namespace App\Services\Slug;

use App\Core\Interfaces\SlugableInterface;
use App\Models\Slug;
use App\Services\Slug\SlugServiceInterface;

class SlugService implements SlugServiceInterface
{


    public function sync(SlugableInterface $slugable, array $languages = []): void
    {

        $slugableField = (string) $slugable->slugable;

        $slugable->slugs()->delete();
        $translations = [];

        foreach ($languages as $language => $trans)
            if (isset($trans[$slugableField])) {
                $translations[] = [
                    "language_id" => $language,
                    "slugable_id" => $slugable->id,
                    "slugable_type" => $slugable->getMorphClass(),
                    "slug" => slug($trans[$slugableField])
                ];
            }

        Slug::insert($translations);
    }
}

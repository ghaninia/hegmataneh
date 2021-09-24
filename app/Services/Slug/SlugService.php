<?php

namespace App\Services\Slug;

use App\Core\Classes\Slugify;
use App\Repositories\Slug\SlugRepository;
use App\Core\Interfaces\SlugableInterface;
use App\Services\Slug\SlugServiceInterface;

class SlugService implements SlugServiceInterface
{

    protected $slugRepo;

    public function __construct(SlugRepository $slugRepo)
    {
        $this->slugRepo = $slugRepo;
    }

    public function sync(SlugableInterface $slugable, array $languages = []) : void 
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

        app(SlugRepository::class)->createMultiple($translations);
    }
}

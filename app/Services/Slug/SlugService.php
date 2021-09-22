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

    public function sync(SlugableInterface $slugable, array $languages)
    {

        $slugableField = $slugable->slugable;

        $slugable->slugs()
            ->when(
                $isEmpty = empty($languages),
                function ($query) {
                    $query->delete();
                },
                function ($query) use ($languages) {
                    $query
                        ->whereNotIn("language_id", array_keys($languages))
                        ->delete();
                }
            );

        if ($isEmpty) return false;

        array_walk(
            $languages,
            function ($trans, $language) use ($slugable, $slugableField) {
                if (isset($trans[$slugableField])) {
                    $slugable->slugs()->updateOrCreate([
                        "language_id" => $language,
                        "slugable_id" => $slugable->id,
                        "slugable_type" => $slugable->getMorphClass()
                    ], [
                        "slug" => Slugify::create($trans[$slugableField])
                    ]);
                }
            }
        );
    }
}

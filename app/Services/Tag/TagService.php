<?php

namespace App\Services\Tag;

use App\Kernel\Tag\Interfaces\TagableInterface;
use App\Models\Term;
use App\Kernel\Enums\EnumsTerm;
use App\Services\Slug\SlugServiceInterface;
use App\Services\Translation\TranslationServiceInterface;

class TagService implements TagServiceInterface
{
    public function __construct(
        protected TranslationServiceInterface $translationService,
        protected SlugServiceInterface $slugService
    ) {
    }

    /**
     * create or update tag
     * @param array $data
     * @param Term|null $tag
     * @return Term
     */
    public function updateOrCreate(array $data, Term $tag = null): Term
    {
        $term =
            Term::updateOrCreate([
                "id" => $tag->id ?? null
            ], [
                "type" => EnumsTerm::TYPE_TAG
            ]);

        $this->translationService->sync($term, $translations = $data["translations"] ?? []);
        $this->slugService->sync($term, $translations);

        return $term->load(["translations", "slugs"]);
    }


    /**
     * delete tag
     * @param Term $tag
     * @return bool
     */
    public function delete(Term $tag): bool
    {
        return $tag->delete();
    }

    /**
     * get tags list
     * @param array $filters
     * @param bool $isPaginate
     * @param array $relations
     * @return mixed
     */
    public function list(array $filters, bool $isPaginate = TRUE, array $relations = [])
    {
        return
            Term::query()
            ->tags()
            ->filterBy($filters)
            ->with($relations)
            ->when(
                $isPaginate,
                fn ($query) => $query->paginate(),
                fn ($query) => $query->get()
            );
    }

    /**
     * retag for tagable model
     * @param TagableInterface $model
     * @param array $data
     */
    public function sync(TagableInterface $model, array $data = []): void
    {
        $items = [];

        ### ست کردن تایپ در جدول واسط
        array_map(function ($item) use (&$items) {
            $items[$item] = ["type" => EnumsTerm::TYPE_TAG];
        }, $data);

        $model->tags()->sync($items);
    }
}

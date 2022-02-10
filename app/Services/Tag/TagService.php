<?php

namespace App\Services\Tag;

use App\Models\Term;
use App\Core\Enums\EnumsTerm;
use App\Core\Interfaces\TagableInterface;
use App\Services\Tag\TagServiceInterface;
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
     * ساخت برچسب
     * @param array $data
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
     * حذف برچسب
     * @param Term $tag
     * @return boolean
     */
    public function delete(Term $tag): bool
    {
        return $tag->delete();
    }

    /**
     * لیست تمام فیلتر
     * @param array $filters
     * @param bool $isPaginate
     * @param array $relations
     * @return Paginator
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
     * مدیریت برچسب های
     * @param TagableInterface $model
     * @param array $data
     *
     * @return void
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

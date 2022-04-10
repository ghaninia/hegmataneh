<?php

namespace App\Services\Category;

use App\Models\Term;
use App\Kernel\Enums\EnumsTerm;
use App\Services\Slug\SlugServiceInterface;
use App\Kernel\Category\Interfaces\CategoryableInterface;
use App\Services\Translation\TranslationServiceInterface;

class CategoryService implements CategoryServiceInterface
{

    public function __construct(
        protected TranslationServiceInterface $translationService,
        protected SlugServiceInterface $slugService
    ) {
    }

    /**
     * create new category
     * @param array $data
     * @param Term|null $category
     * @return Term
     */
    public function updateOrCreate(array $data, Term $category = NULL): Term
    {
        $term =
            Term::updateOrCreate([
                "id" => $category->id ?? null
            ], [
                "term_id" => $data["term_id"] ?? null,
                "color" => $data["color"] ?? null,
                "type" => EnumsTerm::TYPE_CATEGORY
            ]);

        ### ترجمه
        $this->translationService->sync($term, $translations = $data["translations"] ?? []);
        ### لینک پیوند
        $this->slugService->sync($term, $translations);

        return $term->load(["translations", "slugs"]);
    }


    /**
     * delete category
     * @param Term $category
     * @return bool
     */
    public function delete(Term $category): bool
    {
        return $category->delete();
    }

    /**
     * get list categories
     * @param array $filters
     * @return mixed
     */
    public function list(array $filters)
    {
        return
            Term::query()
            ->where("type", EnumsTerm::TYPE_CATEGORY)
            ->filterBy($filters)
            ->with(["files"])
            ->paginate();
    }

    /**
     * sync categoryable model
     * @param CategoryableInterface $model
     * @param array $data
     */
    public function sync(CategoryableInterface $model, array $data = [])
    {
        $items = [];
        /**
         * Set typing in the interface table
         */
        array_map(function ($item) use (&$items) {
            $items[$item] = ["type" => EnumsTerm::TYPE_CATEGORY];
        }, $data);

        $model->categories()->sync($items);
    }
}

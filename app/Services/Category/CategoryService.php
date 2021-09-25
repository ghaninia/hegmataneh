<?php

namespace App\Services\Category;

use App\Models\Term;
use App\Core\Enums\EnumsTerm;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Term\TermRepository;
use App\Services\Slug\SlugServiceInterface;
use App\Services\Category\CategoryServiceInterface;
use App\Services\Translation\TranslationServiceInterface;

class CategoryService implements CategoryServiceInterface
{
    protected $termRepo, $translationService, $slugService;

    public function __construct(
        TermRepository $termRepo,
        TranslationServiceInterface $translationService,
        SlugServiceInterface $slugService
    ) {
        $this->termRepo = $termRepo;
        $this->translationService = $translationService;
        $this->slugService = $slugService;
    }

    /**
     * ساخت دسته بندی
     * @param array $data
     * @return Term
     */
    public function updateOrCreate(array $data, Term $category = NULL): Term
    {
        $term =
            $this->termRepo->updateOrCreate([
                "id" => $category->id ?? null 
            ], [
                "term_id" => $data["term_id"] ?? null,
                "color" => $data["color"] ?? null,
                "type" => EnumsTerm::TYPE_CATEGORY
            ]);

        $this->translationService->sync($term, $translations = $data["translations"] ?? []);
        $this->slugService->sync($term, $translations);

        return $term->load(["translations", "slugs"]);
    }


    /**
     * حذف دسته بندی
     * @param Term $category
     * @return boolean
     */
    public function delete(Term $category): bool
    {
        return $category->delete();
    }


    /**
     * لیست تمام فیلتر
     * @param array $filters
     * @return Paginator
     */
    public function list(array $filters)
    {
        return
            $this->termRepo->query()
            ->where("type", EnumsTerm::TYPE_CATEGORY)
            ->filterBy($filters)
            ->paginate();
    }

    /**
     * مدیریت دسته بندی‌ها
     * @param Model $model
     * @param array $data
     */
    public function sync(Model $model, array $data = [])
    {
        ### ست کردن تایپ در جدول واسط
        array_map(function ($item) use (&$items) {
            $items[$item] = ["type" => EnumsTerm::TYPE_CATEGORY];
        }, $data);


        $model->categories()->sync($items);
    }
}

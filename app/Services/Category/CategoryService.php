<?php

namespace App\Services\Category;

use App\Core\Enums\EnumsFileable;
use App\Models\Term;
use App\Core\Enums\EnumsTerm;
use App\Core\Interfaces\CategoryableInterface;
use App\Services\File\FileService;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Term\TermRepository;
use App\Services\Slug\SlugServiceInterface;
use App\Services\Category\CategoryServiceInterface;
use App\Services\Translation\TranslationServiceInterface;

class CategoryService implements CategoryServiceInterface
{

    public function __construct(
        protected TermRepository $termRepo,
        protected TranslationServiceInterface $translationService,
        protected SlugServiceInterface $slugService,
        protected FileService $fileService
    ) {
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

        ### ترجمه
        $this->translationService->sync($term, $translations = $data["translations"] ?? []);
        ### لینک پیوند
        $this->slugService->sync($term, $translations);
        ### تصویر شاخص
        $this->fileService->sync($term, EnumsFileable::USAGE_THUMBNAIL,  $data["thumbnail"] ?? NULL);
        #### تصویر کاور
        $this->fileService->sync($term, EnumsFileable::USAGE_COVER,  $data["cover"] ?? NULL);

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
            ->with(["files"])
            ->paginate();
    }

    /**
     * مدیریت دسته بندی‌ها
     * @param Model $model
     * @param array $data
     */
    public function sync(CategoryableInterface $model, array $data = [])
    {
        $items = [];
        ### ست کردن تایپ در جدول واسط
        array_map(function ($item) use (&$items) {
            $items[$item] = ["type" => EnumsTerm::TYPE_CATEGORY];
        }, $data);

        $model->categories()->sync($items);
    }
}

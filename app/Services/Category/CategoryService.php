<?php

namespace App\Services\Category;

use App\Models\Term;
use App\Core\Enums\EnumsTerm;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Term\TermRepository;
use App\Services\Category\CategoryServiceInterface;

class CategoryService implements CategoryServiceInterface
{
    protected $termRepo;

    public function __construct(TermRepository $termRepo)
    {
        $this->termRepo = $termRepo;
    }

    /**
     * ساخت دسته بندی
     * @param array $data
     * @return Term
     */
    public function create(array $data): Term
    {
        return
            $this->termRepo->create([
                "term_id" => $data["term_id"] ?? null,
                "name" => $data["name"],
                "slug" => slug($data["slug"] ?? null, $data["name"]),
                "description" => $data["description"] ?? null,
                "color" => $data["color"] ?? null,
                "type" => EnumsTerm::TYPE_CATEGORY
            ]);
    }

    /**
     * ویرایش دسته بندی
     * @param Term $category
     * @param array $data
     * @return Term
     */
    public function update(Term $category, array $data): Term
    {
        return
            $this->termRepo
            ->updateById($category->id, [
                "term_id" => $data["term_id"] ?? null,
                "name" => $data["name"],
                "slug" => slug($data["slug"] ?? null, $data["name"]),
                "description" => $data["description"] ?? null,
                "color" => $data["color"] ?? null,
            ]);
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
        $model->categories()->sync($data);
    }
}

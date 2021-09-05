<?php

namespace App\Services\Tag;

use App\Models\Term;
use App\Core\Enums\EnumsTerm;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Term\TermRepository;
use App\Services\Tag\TagServiceInterface;

class TagService implements TagServiceInterface
{
    protected $termRepo;

    public function __construct(TermRepository $termRepo)
    {
        $this->termRepo = $termRepo;
    }

    /**
     * ساخت برچسب
     * @param array $data
     * @return Term
     */
    public function create(array $data): Term
    {
        return
            $this->termRepo->create([
                "name" => $data["name"],
                "slug" => slug($data["slug"] ?? null, $data["name"]),
                "description" => $data["description"] ?? null,
                "type" => EnumsTerm::TYPE_TAG
            ]);
    }

    /**
     * ویرایش برچسب
     * @param Term $tag
     * @param array $data
     * @return Term
     */
    public function update(Term $tag, array $data): Term
    {
        return
            $this->termRepo
            ->updateById($tag->id, [
                "name" => $data["name"],
                "slug" => slug($data["slug"] ?? null, $data["name"]),
                "description" => $data["description"] ?? null,
            ]);
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
     * @return Paginator
     */
    public function list(array $filters)
    {
        return
            $this->termRepo->query()
            ->where("type", EnumsTerm::TYPE_TAG)
            ->filterBy($filters)
            ->paginate();
    }

    /**
     * مدیریت برچسب های
     * @param Model $model
     * @param array $data
     */
    public function sync(Model $model, array $data = [])
    {
        ### ست کردن تایپ در جدول واسط
        array_map(function ($item) use (&$items) {
            $items[$item] = ["type" => EnumsTerm::TYPE_TAG] ;
        }, $data);

        $model->tags()->sync($items);
    }
}

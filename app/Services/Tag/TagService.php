<?php

namespace App\Services\Tag;

use App\Models\Term;
use App\Core\Enums\EnumsTerm;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Term\TermRepository;
use App\Services\Tag\TagServiceInterface;
use App\Services\Slug\SlugServiceInterface;
use App\Services\Translation\TranslationServiceInterface;

class TagService implements TagServiceInterface
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
     * ساخت برچسب
     * @param array $data
     * @return Term
     */
    public function updateOrCreate(array $data, Term $tag = null): Term
    {
        $term =
            $this->termRepo->updateOrCreate([
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
            $items[$item] = ["type" => EnumsTerm::TYPE_TAG];
        }, $data);

        $model->tags()->sync($items);
    }
}

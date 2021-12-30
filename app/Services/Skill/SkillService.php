<?php

namespace App\Services\Skill;

use App\Core\Enums\EnumsFileable;
use App\Models\Skill;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Skill\SkillRepository;
use App\Services\File\FileService;
use App\Services\Slug\SlugServiceInterface;
use App\Services\Skill\SkillServiceInterface;
use Illuminate\Contracts\Pagination\Paginator;
use App\Services\Translation\TranslationServiceInterface;

class SkillService implements SkillServiceInterface
{
    public function __construct(
        public SkillRepository $skillRepo,
        public TranslationServiceInterface $translationService,
        public SlugServiceInterface $slugService ,
        public FileService $fileService
    ) {
    }

    /**
     * لیست مهارت ها
     * @param array $filters
     * @return Paginator
     */
    public function list(array $filters): Paginator
    {
        return
            $this->skillRepo->query()
            ->filterBy($filters)
            ->paginate();
    }

    /**
     * ساخت مهارت جدید
     * @param array $data
     * @return Skill
     */
    public function updateOrCreate(array $data, Skill $skill = null): Skill
    {
        $skill =
            $this->skillRepo->updateOrCreate([
                "id" => $skill->id ?? null
            ], [
                "icon" => $data["icon"] ?? null
            ]);

        $this->translationService->sync($skill, $translations = $data["translations"] ?? []);
        $this->slugService->sync($skill, $translations);
        ### تصویر شاخص
        $this->fileService->sync($skill, EnumsFileable::USAGE_THUMBNAIL,  $data["thumbnail"] ?? NULL);

        return $skill->load(["translations", "slugs" , "files"]);
    }


    /**
     * حذف مهارت
     * @param Skill $skill
     * @return boolean
     */
    public function delete(Skill $skill): bool
    {
        return $this->skillRepo->delete($skill);
    }

    /**
     * مدیریت مهارتها
     * @param Model $model
     * @param array $skills
     */
    public function sync(Model $model, array $skills)
    {
        $model->skills()->sync($skills);
    }
}

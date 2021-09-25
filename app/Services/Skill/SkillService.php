<?php

namespace App\Services\Skill;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Skill\SkillRepository;
use App\Services\Slug\SlugServiceInterface;
use App\Services\Skill\SkillServiceInterface;
use Illuminate\Contracts\Pagination\Paginator;
use App\Services\Translation\TranslationServiceInterface;

class SkillService implements SkillServiceInterface
{

    protected $skillRepo, $translationService, $slugService;

    public function __construct(
        SkillRepository $skillRepo,
        TranslationServiceInterface $translationService,
        SlugServiceInterface $slugService
    ) {
        $this->skillRepo = $skillRepo;
        $this->translationService = $translationService;
        $this->slugService = $slugService;
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

        return $skill->load(["translations", "slugs"]);
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

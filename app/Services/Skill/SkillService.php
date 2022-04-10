<?php

namespace App\Services\Skill;

use App\Models\Skill;
use App\Kernel\Enums\EnumsFileable;
use Illuminate\Database\Eloquent\Model;
use App\Services\Slug\SlugServiceInterface;
use Illuminate\Contracts\Pagination\Paginator;
use App\Services\Translation\TranslationServiceInterface;

class SkillService implements SkillServiceInterface
{
    public function __construct(
        public TranslationServiceInterface $translationService,
        public SlugServiceInterface $slugService
    ) {
    }

    /**
     * get list skills
     * @param array $filters
     * @return Paginator
     */
    public function list(array $filters): Paginator
    {
        return
            Skill::query()
            ->filterBy($filters)
            ->paginate();
    }

    /**
     * create or update skill
     * @param array $data
     * @param Skill|null $skill
     * @return Skill
     */
    public function updateOrCreate(array $data, Skill $skill = null): Skill
    {
        $skill =
            Skill::updateOrCreate([
                "id" => $skill->id ?? null
            ], [
                "icon" => $data["icon"] ?? null
            ]);

        $this->translationService->sync($skill, $translations = $data["translations"] ?? []);
        $this->slugService->sync($skill, $translations);

        return $skill->load(["translations", "slugs", "files"]);
    }


    /**
     * delete skill
     * @param Skill $skill
     * @return bool
     */
    public function delete(Skill $skill): bool
    {
        return $skill->delete() ;
    }

    /**
     * Add and remove skills
     * @param Model $model
     * @param array $skills
     */
    public function sync(Model $model, array $skills)
    {
        $model->skills()->sync($skills);
    }
}

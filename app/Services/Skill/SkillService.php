<?php

namespace App\Services\Skill;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Skill\SkillRepository;
use App\Services\Skill\SkillServiceInterface;
use Illuminate\Contracts\Pagination\Paginator;

class SkillService implements SkillServiceInterface
{

    protected $skillRepo;
    public function __construct(SkillRepository $skillRepo)
    {
        $this->skillRepo = $skillRepo;
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
    public function create(array $data): Skill
    {
        return
            $this->skillRepo->create([
                "title" => $data["title"],
                "icon" => $data["icon"] ?? null
            ]);
    }

    /**
     * ویرایش مهارت
     * @param Skill $skill
     * @param array $data
     * @return Skill
     */
    public function update(Skill $skill, array $data): Skill
    {
        return
            $this->skillRepo->updateById($skill->id, [
                "title" => $data["title"],
                "icon" => $data["icon"] ?? null
            ]);
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

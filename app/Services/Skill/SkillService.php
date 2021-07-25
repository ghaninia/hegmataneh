<?php

namespace App\Services\Skill;

use App\Models\Skill;
use Illuminate\Support\Collection;
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
                "title_fa" => $data["title_fa"],
                "title_en" => $data["title_en"] ?? null,
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
                "title_fa" => $data["title_fa"],
                "title_en" => $data["title_en"] ?? null,
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
        return $this->skillRepo->delete($skill) ;
    }
}

<?php

namespace App\Services\Skill;

use Illuminate\Support\Collection;
use App\Repositories\Skill\SkillRepository;
use App\Services\Skill\SkillServiceInterface;

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
     * @return Collection
     */
    public function list(array $filters): Collection
    {
        return
            $this->skillRepo->query()
            ->filterBy($filters)
            ->get();
    }
}

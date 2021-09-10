<?php

namespace App\Repositories\Skill;

use App\Models\Skill;
use App\Repositories\Skill\SkillRepositoryInterface;
use App\Core\Traits\ExteraQueriesTrait;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

class SkillRepository extends BaseRepository implements SkillRepositoryInterface
{
    use ExteraQueriesTrait ;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Skill::class ;
    }

    public function query()
    {
        return $this->model;
    }
}

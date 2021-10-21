<?php

namespace App\Repositories\Experience;

use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;
use App\Repositories\Experience\ExperienceRepositoryInterface;

class ExperienceRepository extends BaseRepository implements ExperienceRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        //return;
    }
}

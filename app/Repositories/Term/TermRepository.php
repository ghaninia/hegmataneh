<?php

namespace App\Repositories\Term;

use App\Models\Term;
use App\Repositories\Term\TermRepositoryInterface;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

class TermRepository extends BaseRepository implements TermRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Term::class ;
    }

    public function query()
    {
        return $this->model ;
    }
}

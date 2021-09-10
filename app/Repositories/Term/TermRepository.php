<?php

namespace App\Repositories\Term;

use App\Models\Term;
use App\Repositories\Term\TermRepositoryInterface;
use App\Core\Traits\ExteraQueriesTrait;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

class TermRepository extends BaseRepository implements TermRepositoryInterface
{
    use ExteraQueriesTrait ;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Term::class ;
    }

}

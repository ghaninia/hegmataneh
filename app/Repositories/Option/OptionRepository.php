<?php

namespace App\Repositories\Option;

use App\Models\Option;
use App\Repositories\Option\OptionRepositoryInterface;
use App\Core\Traits\ExteraQueriesTrait;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

class OptionRepository extends BaseRepository implements OptionRepositoryInterface
{

    use ExteraQueriesTrait ;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Option::class;
    }

}

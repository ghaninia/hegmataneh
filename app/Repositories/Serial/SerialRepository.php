<?php

namespace App\Repositories\Serial;

use App\Models\Serial;
use App\Repositories\Serial\SerialRepositoryInterface;
use App\Core\Traits\ExteraQueriesTrait;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

class SerialRepository extends BaseRepository implements SerialRepositoryInterface
{
    use ExteraQueriesTrait ;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Serial::class;
    }
}

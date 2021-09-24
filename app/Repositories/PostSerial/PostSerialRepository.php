<?php

namespace App\Repositories\PostSerial;

use App\Models\PostSerial;
use App\Core\Traits\ExteraQueriesTrait;
use App\Repositories\PostSerial\PostSerialRepositoryInterface;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

class PostSerialRepository extends BaseRepository implements PostSerialRepositoryInterface
{
    use ExteraQueriesTrait;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PostSerial::class;
    }
}

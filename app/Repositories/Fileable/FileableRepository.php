<?php

namespace App\Repositories\Fileable;

use App\Models\Fileable;
use App\Repositories\Fileable\FileableRepositoryInterface;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

class FileableRepository extends BaseRepository implements FileableRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Fileable::class ;
    }
}

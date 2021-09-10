<?php

namespace App\Repositories\File;

use App\Models\File;
use App\Repositories\File\FileRepositoryInterface;
use App\Core\Traits\ExteraQueriesTrait;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

class FileRepository extends BaseRepository implements FileRepositoryInterface
{
    use ExteraQueriesTrait ;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return File::class;
    }
}

<?php

namespace App\Repositories\File;

use App\Models\File;
use App\Repositories\File\FileRepositoryInterface;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

class FileRepository extends BaseRepository implements FileRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return File::class;
    }

    public function query()
    {
        return $this->model;
    }
}

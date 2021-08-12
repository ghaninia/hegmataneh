<?php

namespace App\Repositories\Permission;

use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;
use App\Repositories\Permission\PermissionRepositoryRepositoryInterface;

class PermissionRepositoryRepository extends BaseRepository implements PermissionRepositoryRepositoryInterface
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

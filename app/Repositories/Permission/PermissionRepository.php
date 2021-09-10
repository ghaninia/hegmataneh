<?php

namespace App\Repositories\Permission;

use App\Models\Permission;
use App\Core\Traits\ExteraQueriesTrait;
use App\Repositories\Permission\PermissionRepositoryInterface;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{

    use ExteraQueriesTrait ;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Permission::class;
    }

}

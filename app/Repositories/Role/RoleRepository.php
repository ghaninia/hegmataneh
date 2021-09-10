<?php

namespace App\Repositories\Role;

use App\Models\Role;
use App\Core\Traits\ExteraQueriesTrait;
use App\Repositories\Role\RoleRepositoryInterface;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    use ExteraQueriesTrait ;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Role::class ;
    }


}

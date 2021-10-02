<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Core\Traits\ExteraQueriesTrait;
use App\Repositories\User\UserRepositoryInterface;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    use ExteraQueriesTrait ;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

}

<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    public function query()
    {
        return $this->model ;
    }
}

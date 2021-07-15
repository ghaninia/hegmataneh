<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Services\User\UserServiceInterface;

class UserService implements UserServiceInterface
{
    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        return $this->userRepo->create([
            'name' => $this->data["name"] ,
            'confirm' => ,
            'role_id' => $data[""],
            'email' => $data["name"],
            'mobile' => $data["name"],
            "username" => $data["name"],
            'password' => $data["name"],
            "remember_token"  => Str::random(10) ,
            "bio => $data["bio"],
        ]);
    }
}

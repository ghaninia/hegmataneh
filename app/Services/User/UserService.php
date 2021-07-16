<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Str;
use App\Core\Enums\EnumsUser;
use App\Repositories\User\UserRepository;
use App\Services\User\UserServiceInterface;
use Illuminate\Contracts\Pagination\Paginator;
use App\Notifications\ConfirmAccountNotification;

class UserService implements UserServiceInterface
{
    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * ساخت کاربر جدید
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        return $this->userRepo->create([
            'name' => $data["name"] ?? null,
            'status' => (bool) $data["status"],
            'role_id' => $data["role_id"],
            'email' => $data["email"],
            'mobile' => $data["mobile"] ?? null,
            "username" => $data["username"] ?? null,
            'password' => bcrypt($data["password"]),
            "remember_token"  => $this->rememberTokenGenerate(),
            "bio" => $data["bio"] ?? null
        ]);
    }

    /**
     * ویرایش کاربر
     * @param User $user
     * @param array $data
     * @return User
     */
    public function update(User $user, array $data): User
    {
        $updateFields = [
            'name' => $data["name"] ?? null,
            'status' => (bool) $data["status"],
            'role_id' => $data["role_id"],
            'email' => $data["email"],
            'mobile' => $data["mobile"] ?? null,
            "username" => $data["username"] ?? null,
            "remember_token"  => $this->rememberTokenGenerate(),
            "bio" => $data["bio"] ?? null
        ];

        if(isset($data["password"]))
            $updateFields['password'] = bcrypt($data["password"]) ;

        return $this->userRepo->updateById(
            $user->id,
            $updateFields
        );
    }

    /**
     * حذف امن کاربر :)
     * @param User $user
     * @return boolean
     */
    public function delete(User $user): bool
    {
        return $this->userRepo->deleteById($user->id) ;
    }

    /**
     *
     * @param User $user
     * @return void
     */
    public function sendVerifyNotification(User $user): void
    {
        $user->notify(
            new ConfirmAccountNotification($user)
        );
    }


    /**
     * تایید حساب کاربری
     * @param string $token
     * @return ?User $user
     */
    public function verify(string $token): ?User
    {

        $user = $this->userRepo->query()
            ->where("status", EnumsUser::STATUS_DISABLE)
            ->where("remember_token", $token)
            ->first();

        return
            is_null($user) ? NULL :
            $this->userRepo->updateById(
                $user->id,
                [
                    "remember_token"  => $this->rememberTokenGenerate(),
                    "status" => EnumsUser::STATUS_ENABLE
                ]
            );
    }

    /**
     * ساخت توکن جدید
     * @return string
     */
    private function rememberTokenGenerate(): string
    {
        return Str::random(30);
    }

    /**
     * لیست تمام کاربران
     * @param array $filters
     * @return Paginator
     */
    public function list(array $filters): Paginator
    {
        return
            $this->userRepo->query()
            ->filterBy($filters)
            ->paginate();
    }
}

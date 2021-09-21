<?php

namespace App\Services\User;

use Carbon\Carbon;
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
        return
            $this->userRepo->create([
                'name' => $data["name"] ?? null,
                'status' => (bool) $data["status"],
                'email' => $data["email"],
                'mobile' => $data["mobile"] ?? null,
                "username" => $data["username"] ?? null,
                'password' => bcrypt($data["password"]),
                "remember_token"  => $this->rememberTokenGenerate(),
                "bio" => $data["bio"] ?? null,
                'role_id' => $data["role_id"],
                "currency_id" =>  $data["currency_id"] ?? null ,
                "language_id" =>  $data["language_id"] ?? null ,
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
            'email' => $data["email"],
            'mobile' => $data["mobile"] ?? null,
            "username" => $data["username"] ?? null,
            "remember_token"  => $this->rememberTokenGenerate(),
            "bio" => $data["bio"] ?? null ,
            'role_id' => $data["role_id"],
            "currency_id" =>  $data["currency_id"] ?? null ,
            "language_id" =>  $data["language_id"] ?? null ,
        ];

        if (isset($data["password"]))
            $updateFields['password'] = bcrypt($data["password"]);

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
        return $this->userRepo->deleteById($user->id);
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
            ->whereNull("verified_at")
            ->where("remember_token", $token)
            ->first();

        $user =
            is_null($user) ? NULL :
            $this->userRepo->updateById(
                $user->id,
                [
                    "remember_token"  => $this->rememberTokenGenerate(),
                    "status" => EnumsUser::STATUS_ENABLE,
                    "verified_at" => Carbon::now()
                ]
            );

        return $user ;
    }

    /**
     * ساخت توکن جدید
     * @return string
     */
    public function rememberTokenGenerate(): string
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

<?php

namespace App\Services\User;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use App\Core\Enums\EnumsUser;
use Illuminate\Support\Collection;
use App\Services\User\UserServiceInterface;
use Illuminate\Contracts\Pagination\Paginator;
use App\Notifications\ConfirmAccountNotification;

class UserService implements UserServiceInterface
{

    /**
     * ساخت و ویرایش کاربر
     * @param array $data
     * @return User
     */
    public function updateOrCreate(array $data, User $user = null): User
    {

        $insertData = [
            'name' => $data["name"] ?? null,
            'status' => (bool) $data["status"],
            'email' => $data["email"],
            'mobile' => $data["mobile"] ?? null,
            "username" => $data["username"] ?? null,
            "bio" => $data["bio"] ?? null,
            'role_id' => $data["role_id"],
            "currency_id" =>  $data["currency_id"] ?? null,
            "language_id" =>  $data["language_id"] ?? null,
        ];

        if (is_null($user)) {
            $insertData['password'] = bcrypt($data["password"]);
            $insertData["remember_token"]  = $this->rememberTokenGenerate();
        }

        return
            User::updateOrCreate(
                ["id" => $user?->id],
                $insertData
            );
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
            "bio" => $data["bio"] ?? null,
            'role_id' => $data["role_id"],
            "currency_id" =>  $data["currency_id"] ?? null,
            "language_id" =>  $data["language_id"] ?? null,
        ];

        if (isset($data["password"]))
            $updateFields['password'] = bcrypt($data["password"]);

        $user->update($updateFields);

        return $user->refresh();
    }

    /**
     * حذف امن کاربر :)
     * @param User $user
     * @return boolean
     */
    public function delete(User $user): bool
    {
        return $user->delete();
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
        $user = User::query()
            ->whereNull("verified_at")
            ->where("remember_token", $token)
            ->first();

        $user?->update([
            "remember_token"  => $this->rememberTokenGenerate(),
            "status" => EnumsUser::STATUS_ENABLE,
            "verified_at" => Carbon::now()
        ]);

        return $user ?? false;
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
    public function list(array $filters): Paginator|Collection
    {
        return
            User::query()
            ->with([
                "currency", "language", "role"
            ])
            ->withTrashed()
            ->filterBy($filters)
            ->paginate();
    }
}

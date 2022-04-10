<?php

namespace App\Services\User;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use App\Kernel\Enums\EnumsUser;
use Illuminate\Support\Collection;
use App\Services\User\UserServiceInterface;
use Illuminate\Contracts\Pagination\Paginator;
use App\Notifications\ConfirmAccountNotification;

class UserService implements UserServiceInterface
{

    /**
     * create or update user
     * @param array $data
     * @param User|null $user
     * @return User
     */
    public function updateOrCreate(array $data, User $user = null): User
    {
        $insertData = [
            'name' => $data["name"] ?? $user->name ?? null  ,
            'status' => $data["status"] ?? $user?->status ?? false ,
            'email' => $data["email"] ?? $user->email ?? null ,
            'mobile' => $data["mobile"] ?? $user->mobile ?? null ,
            'username' => $data["username"] ?? $user->username ?? null ,
            'bio' => $data["bio"] ?? $user->bio ?? null ,
            'role_id' => $data["role_id"] ?? $user?->role_id ,
            'currency_id' => $data["currency_id"] ?? $user?->currency_id ?? null  ,
            'language_id' => $data["language_id"] ?? $user?->language_id ?? null  ,
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
     * delete user
     * @param User $user
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->delete();
    }

    /**
     * send verify notification
     * @param User $user
     */
    public function sendVerifyNotification(User $user): void
    {
        $user->notify(
            new ConfirmAccountNotification($user)
        );
    }

    /**
     * verify new user
     * @param string $token
     * @return User|null
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
     * generate remember token
     * @return string
     */
    public function rememberTokenGenerate(): string
    {
        return Str::random(30);
    }

    /**
     * get all users list
     * @param array $filters
     * @return Paginator|Collection
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

<?php

namespace App\Services\Serial;

use App\Models\User;
use App\Models\Serial;
use App\Repositories\Serial\SerialRepository;
use App\Services\Serial\SerialServiceInterface;

class SerialService implements SerialServiceInterface
{

    protected $serialRepo;

    public function __construct(SerialRepository $serialRepo)
    {
        $this->serialRepo = $serialRepo;
    }

    /**
     * لیست تمام سریال ها
     * @param array $filters
     * @return Paginator
     */
    public function list(array $filters)
    {
        return
            $this->serialRepo->query()
            ->filterBy($filters)
            ->paginate();
    }

    /**
     * ساخت سریال جدید
     * @param User $user
     * @param array $data
     * @return Serial
     */
    public function create(User $user,  array $data)
    {
        return $this->serialRepo->create([
            "user_id" => $user->id,
            "title" => $data["title"],
            "description" => $data["description"]
        ]);
    }

    /**
     * ویرایش سریال
     * @param User $user
     * @param Serial $serial
     * @param array $data
     */
    public function update(User $user, Serial $serial, array $data)
    {
        return $this->serialRepo->updateById($serial->id, [
            "user_id" => $user->id,
            "title" => $data["title"],
            "description" => $data["description"]
        ]);
    }

    /**
     * اضافه کردن اپیزود به سریال
     * @param Serial $serial
     * @param array $data
     */
    public function episodes(Serial $serial, array $data): void
    {
        $data =
            array_map(function ($item) {
                return [
                    "title" => $item["title"],
                    "is_locked" => (bool)($item["is_locked"] ?? false),
                    "priority" => $item["priority"] ?? null,
                    "description" => $item["description"] ?? null
                ];
            }, $data);

        $serial->posts()->sync($data);
    }

    /**
     * حذف سریال
     * @param Serial $serial
     * @return bool
     */
    public function delete(Serial $serial): bool
    {
        $serial->price()->delete();
        $serial->posts()->detach();
        return $serial->delete();
    }
}

<?php

namespace App\Services\Serial;

use App\Models\Episode;
use App\Models\User;
use App\Models\Serial;
use App\Services\Tag\TagService;
use App\Services\Category\CategoryService;
use App\Services\Slug\SlugServiceInterface;
use App\Services\Price\PriceServiceInterface;
use App\Services\Serial\SerialServiceInterface;
use App\Services\Translation\TranslationService;

class SerialService implements SerialServiceInterface
{

    public function __construct(
        protected TranslationService $translationService,
        protected SlugServiceInterface $slugService,
        protected CategoryService $categoryService,
        protected TagService $tagService,
        protected PriceServiceInterface $priceService
    ) {
    }

    /**
     * get all serials
     * @param array $filters
     * @return mixed
     */
    public function list(array $filters)
    {
        return
            Serial::query()
            ->filterBy($filters)
            ->with(["prices"])
            ->paginate();
    }

    /**
     * create or update serial
     * @param User $user
     * @param array $data
     * @param Serial|null $serial
     * @return mixed
     */
    public function updateOrCreate(User $user, array $data, Serial $serial = null)
    {
        $serial =
            Serial::updateOrCreate(
                ["id" => $serial->id ?? null],
                ["user_id" => $user->id],
            );

        $this->translationService->sync($serial, $translations = $data["translations"] ?? []);
        $this->slugService->sync($serial, $translations);

        if (isset($data["episodes"]))
            $this->episodes($serial, $data["episodes"]);

        $this->tagService->sync(
            $serial,
            $data["tags"] ?? []
        );

        $this->categoryService->sync(
            $serial,
            $data["categories"] ?? []
        );

        if (isset($data["currencies"]))
            $this->priceService->create(
                $serial,
                $data["currencies"]
            );

        return $serial->load([
            "prices",
            "translations",
            "episodes.post",
            "tags",
            "slugs",
            "categories",
        ]);
    }

    /**
     * Add episode to serial
     * @param Serial $serial
     * @param array $data
     */
    public function episodes(Serial $serial, array $data): void
    {

        $posts = array_keys($data);
        $isEmptyPosts = empty($posts);

        $serial
            ->episodes()
            ->when(!$isEmptyPosts, function ($query) use ($posts) {
                $query->whereNotIn("post_id", $posts);
            })
            ->delete();

        if ($isEmptyPosts) return;

        array_walk($data, function ($item, $post) use ($serial) {
            $episode = Episode::updateOrCreate([
                "serial_id" => $serial->id,
                "post_id" => $post
            ], [
                "is_locked" => (bool)($item["is_locked"] ?? false),
                "priority" => $item["priority"] ?? null,
            ]);
            $this->translationService->sync($episode, $item["translations"]);
        });
    }

    /**
     * delete serial
     * @param Serial $serial
     * @return bool
     */
    public function delete(Serial $serial): bool
    {
        return $serial->delete();
    }
}

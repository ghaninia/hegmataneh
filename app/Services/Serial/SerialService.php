<?php

namespace App\Services\Serial;

use App\Models\User;
use App\Models\Serial;
use App\Services\Tag\TagService;
use App\Services\Category\CategoryService;
use App\Services\Slug\SlugServiceInterface;
use App\Repositories\Serial\SerialRepository;
use App\Services\Price\PriceServiceInterface;
use App\Repositories\Episode\EpisodeRepository;
use App\Services\Serial\SerialServiceInterface;
use App\Services\Translation\TranslationService;

class SerialService implements SerialServiceInterface
{

    protected
        $translationService,
        $categoryService,
        $slugService,
        $episodeRepo,
        $serialRepo,
        $tagService,
        $priceService;

    public function __construct(
        SerialRepository $serialRepo,
        TranslationService $translationService,
        EpisodeRepository $episodeRepo,
        SlugServiceInterface $slugService,
        CategoryService $categoryService,
        TagService $tagService,
        PriceServiceInterface $priceService
    ) {
        $this->serialRepo = $serialRepo;
        $this->episodeRepo = $episodeRepo;
        $this->translationService = $translationService;
        $this->slugService = $slugService;
        $this->categoryService = $categoryService;
        $this->tagService = $tagService;
        $this->priceService = $priceService;
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
    public function updateOrCreate(User $user, array $data, Serial $serial = null)
    {
        $serial =
            $this->serialRepo->updateOrCreate(
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
     * اضافه کردن اپیزود به سریال
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
            $episode = $this->episodeRepo->updateOrCreate([
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
     * حذف سریال
     * @param Serial $serial
     * @return bool
     */
    public function delete(Serial $serial): bool
    {
        return $serial->delete();
    }
}

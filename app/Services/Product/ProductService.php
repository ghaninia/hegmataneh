<?php

namespace App\Services\Product;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Kernel\Enums\EnumsPost;
use App\Services\Tag\TagService;
use App\Services\Slug\SlugService;
use Illuminate\Support\Facades\DB;
use App\Services\Skill\SkillService;
use App\Services\Category\CategoryService;
use App\Services\Price\PriceServiceInterface;
use App\Services\Product\ProductServiceInterface;
use App\Services\Translation\TranslationServiceInterface;
use App\Services\Product\Information\ProductInformationService;

class ProductService implements ProductServiceInterface
{


    /**
     * @param ProductInformationService $productInformationService
     * @param TranslationServiceInterface $translationService
     * @param PriceServiceInterface $priceService
     * @param CategoryService $categoryService
     * @param SkillService $skillService
     * @param SlugService $slugService
     * @param TagService $tagService
     */
    public function __construct(
        protected ProductInformationService $productInformationService,
        protected TranslationServiceInterface $translationService,
        protected PriceServiceInterface $priceService,
        protected CategoryService $categoryService,
        protected SkillService $skillService,
        protected SlugService $slugService,
        protected TagService $tagService
    ) {
    }

    /**
     * get all products
     * @param array $filters
     * @return mixed
     */
    public function list(array $filters)
    {
        return
            Post::query()
            ->where("type", EnumsPost::TYPE_PRODUCT)
            ->filterBy($filters)
            ->with(["translations", "slugs", "prices", "categories", "tags", "skills"])
            ->paginate();
    }

    /**
     * create or update product
     * @param User $user
     * @param array $data
     * @param Post|null $product
     * @return Post
     */
    public function updateOrCreate(User $user, array $data, ?Post $product = null): Post
    {
        $product =
            Post::updateOrCreate([
                "id" => $product->id ?? null
            ], [
                "user_id" => $user->id,
                "status" => $data["status"],
                "comment_status" => $data["comment_status"] ?? false,
                "vote_status" => $data["vote_status"] ?? false,
                "published_at" => $data["published_at"] ?? NULL,
                "created_at" => $product->created_at ?? $data["created_at"] ?? Carbon::now(),
                "type" => EnumsPost::TYPE_PRODUCT,
                "format" => EnumsPost::FORMAT_CONTEXT,
            ]);

        $this->productInformationService->updateOrCreate($product, $data);

        $this->translationService->sync($product, $translations = $data["translations"] ?? []);
        $this->slugService->sync($product, $translations);

        $this->tagService->sync(
            $product,
            $data["tags"] ?? []
        );

        $this->categoryService->sync(
            $product,
            $data["categories"] ?? []
        );

        ### after create post , create price for it
        if (isset($data["currencies"]))
            $this->priceService->create(
                $product,
                $data["currencies"]
            );

        ### append skill
        if (isset($data["skills"]))
            $this->skillService->sync(
                $product,
                $data["skills"]
            );

        return $product->load(["translations", "slugs", "prices"]);
    }

    /**
     * delete product
     * @param Post $product
     * @return bool|null
     */
    public function delete(Post $product)
    {
        return $product->delete();
    }

    /**
     * restore product
     *
     * @param Post $product
     * @return bool|null
     */
    public function restore(Post $product)
    {
        return $product->restore();
    }

    /**
     * force delete product
     * @param Post $product
     */
    public function forceDelete(Post $product): void
    {
        $$product->forceDelete();
    }
}

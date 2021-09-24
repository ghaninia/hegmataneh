<?php

namespace App\Services\Product;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Core\Enums\EnumsPost;
use App\Services\Tag\TagService;
use App\Services\Slug\SlugService;
use Illuminate\Support\Facades\DB;
use App\Services\Skill\SkillService;
use App\Repositories\Post\PostRepository;
use App\Services\Category\CategoryService;
use App\Services\Price\PriceServiceInterface;
use App\Services\Translation\TranslationService;
use App\Services\Product\ProductServiceInterface;
use App\Services\Product\Information\ProductInformationService;

class ProductService implements ProductServiceInterface
{
    protected
        $productInformationService,
        $translationService,
        $categoryService,
        $priceService,
        $skillService,
        $slugService,
        $tagService,
        $postRepo;

    public function __construct(
        ProductInformationService $productInformationService,
        TranslationService $translationService,
        PriceServiceInterface $priceService,
        CategoryService $categoryService,
        SkillService $skillService,
        PostRepository $postRepo,
        SlugService $slugService,
        TagService $tagService
    ) {
        $this->productInformationService = $productInformationService;
        $this->translationService = $translationService;
        $this->categoryService = $categoryService;
        $this->priceService = $priceService;
        $this->skillService = $skillService;
        $this->slugService = $slugService;
        $this->tagService = $tagService;
        $this->postRepo = $postRepo;
    }

    /**
     * لیست تمام محصولات
     * @param array $filters
     * @return Paginator
     */
    public function list(array $filters)
    {
        return
            $this->postRepo->query()
            ->where("type", EnumsPost::TYPE_PRODUCT)
            ->filterBy($filters)
            ->with(["translations", "slugs", "prices", "categories", "tags", "skills"])
            ->paginate();
    }

    /**
     * ثبت محصول جدید
     * @param User $user
     * @param array $data
     * @param Post $product|null
     */
    public function updateOrCreate(User $user, array $data, ?Post $product = null): Post
    {
        DB::beginTransaction();

        $product =
            $this->postRepo->updateOrCreate([
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

        DB::commit();

        return $product->load(["translations", "slugs", "prices"]);
    }

    /**
     * حذف محصولات
     * @param Post $product
     * @return boolean
     */
    public function delete(Post $product)
    {
        return $this->postRepo->delete($product);
    }

    /**
     * رستور کردن محصولات حذف شده
     * @param Post $product
     * @return boolean
     */
    public function restore(Post $product)
    {
        return $this->postRepo->restore($product);
    }

    /**
     * حذف اجباری محصولات
     * @param Post $product
     * @return void
     */
    public function forceDelete(Post $product): void
    {
        $this->postRepo->forceDelete($product);
    }
}

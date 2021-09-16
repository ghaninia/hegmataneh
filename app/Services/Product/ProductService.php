<?php

namespace App\Services\Product;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Core\Enums\EnumsPost;
use App\Repositories\Post\PostRepository;
use App\Services\Product\ProductServiceInterface;
use App\Services\Product\Information\ProductInformationService;

class ProductService implements ProductServiceInterface
{
    protected $postRepo, $productInformationService;

    public function __construct(
        PostRepository $postRepo,
        ProductInformationService $productInformationService
    ) {
        $this->postRepo = $postRepo;
        $this->productInformationService = $productInformationService;
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
        $product =
            $this->postRepo->updateOrCreate([
                "id" => $product->id ?? null
            ], [
                "user_id" => $user->id,
                "title" => $data["title"],
                "slug" => slug($data["slug"] ?? NULL, $data["title"]),
                "content" => $data["content"] ?? NULL,
                "faq" => $data["faq"] ?? NULL,
                "excerpt" => $data["excerpt"] ?? NULL,
                "status" => $data["status"],
                "comment_status" => $data["comment_status"] ?? false,
                "vote_status" => $data["vote_status"] ?? false,
                "goal_post" => $data["goal_post"] ?? NULL,
                "published_at" => $data["published_at"] ?? NULL,
                "created_at" => $product->created_at ?? $data["created_at"] ?? Carbon::now(),
                "type" => EnumsPost::TYPE_PRODUCT,
                "format" => EnumsPost::FORMAT_CONTEXT,
            ]);

        $this->productInformationService->updateOrCreate($product, $data);

        return $product;
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
     * @return boolean
     */
    public function forceDelete(Post $product): bool
    {
        $product->price()->delete();
        $product->productInformation()->delete();
        return $this->postRepo->forceDelete($product);
    }
}

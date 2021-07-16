<?php

namespace App\Services\Product;

use App\Core\Enums\EnumsPost;
use App\Repositories\Post\PostRepository;
use App\Services\Product\ProductServiceInterface;

class ProductService implements ProductServiceInterface
{
    protected $postRepo;
    public function __construct(PostRepository $postRepo)
    {
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
            ->paginate();
    }
}

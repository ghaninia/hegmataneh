<?php

namespace App\Http\Controllers\Api\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Tag\TagService;
use App\Services\Post\PostService;
use App\Http\Controllers\Controller;
use App\Services\Price\PriceService;
use App\Services\Skill\SkillService;
use App\Services\Product\ProductService;
use App\Services\Category\CategoryService;
use App\Http\Requests\Product\ProductIndex;
use App\Http\Requests\Product\ProductStore;
use App\Http\Requests\Product\ProductUpdate;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductCollection;

class ProductController extends Controller
{
    protected
        $tagService,
        $categoryService,
        $productService,
        $priceService,
        $skillService;

    public function __construct(
        ProductService $productService,
        TagService $tagService,
        CategoryService $categoryService,
        PriceService $priceService,
        SkillService $skillService,
        PostService $postService
    ) {
        $this->productService = $productService;
        $this->priceService = $priceService;
        $this->tagService = $tagService;
        $this->categoryService = $categoryService;
        $this->skillService = $skillService;
        $this->postService = $postService;
    }

    /**
     * ساخت یا ویرایش یک محصول جدید
     * @param User $user
     * @param Request $request
     * @param Post $product
     * @return Product
     */
    private function product(User $user,  Request $request, Post $product = null)
    {
        ### create new product
        $product = $this->productService->updateOrCreate(
            $user,
            $request->only([
                "title",
                "slug",
                "content",
                "excerpt",
                "faq",
                "status",
                "comment_status",
                "vote_status",
                "created_at",
                "published_at",
                "maximum_sell",
                "expire_day",
                "download_limit",
            ]),
            $product
        );

        ### after create post , create price for it
        $this->priceService->create(
            $product,
            $request->input("currencies")
        );

        ### append tag
        $this->tagService->sync(
            $product,
            $request->input("tags", [])
        );

        ### append category
        $this->categoryService->sync(
            $product,
            $request->input("categories", [])
        );

        ### append skill
        $this->skillService->sync(
            $product,
            $request->input("skills", [])
        );

        return $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, ProductIndex $request)
    {

        $filters = array_merge(
            ["user" => $user->id],
            $request->only([
                "price",
                "comment_status",
                "vote_status",
                "status",
                "format",
                "slug",
                "title",
                "content",
                "created_at",
                "published_at"
            ])
        );

        $products = $this->productService->list($filters);

        return new ProductCollection(
            $products->load([
                "user", "price", "productInformation"
            ])
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  User $user
     * @param  ProductStore $request
     * @return \Illuminate\Http\Response
     */
    public function store(User $user,  ProductStore $request)
    {

        $product = $this->product($user, $request);

        return $this->success([
            "msg" => trans("dashboard.success.product.create"),
            "data" => new ProductResource($product->load([
                "prices", "productInformation", "categories", "tags", "skills"
            ]))
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @param  Post $product
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Post $product)
    {
        return new ProductResource($product->load([
            "prices", "productInformation", "categories", "tags", "skills"
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, Post $product, ProductUpdate $request)
    {

        $product = $this->product($user, $request, $product);

        return $this->success([
            "msg" => trans("dashboard.success.product.update"),
            "data" => new ProductResource($product->load([
                "prices", "productInformation", "categories", "tags", "skills"
            ]))
        ]);
    }


    /**
     * Remove the specified resource from storage.
     * @param  User $user
     * @param  Post $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Post $product)
    {
        $this->productService->delete($product);

        return $this->success([
            "msg" => trans("dashboard.success.product.delete")
        ]);
    }

    /**
     * بازگردانی محصولات حذف شده
     * @param User $user
     * @param Post $product
     * @return \Illuminate\Http\Response
     */
    public function restore(User $user, Post $product)
    {
        $this->productService->restore($product);

        return $this->success([
            "msg" => trans("dashboard.success.product.restore")
        ]);
    }

    /**
     * حذف محصولات بصورت کامل
     * @param User $user
     * @param Post $product
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(User $user, Post $product)
    {
        $this->productService->forceDelete($product);

        return $this->success([
            "msg" => trans("dashboard.success.product.forceDelete")
        ]);
    }
}

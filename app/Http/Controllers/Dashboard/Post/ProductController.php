<?php

namespace App\Http\Controllers\Dashboard\Post;

use App\Models\Post;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Services\Product\ProductService;
use App\Http\Requests\Product\ProductIndex;
use App\Http\Requests\Product\ProductStore;
use App\Http\Requests\Product\ProductUpdate;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductCollection;

class ProductController extends Controller
{

    public function __construct(
        protected ProductService $productService
    ){
    }


    /**
     * Display a listing of the resource
     *
     * @param User $user
     * @param ProductIndex $request
     * @return ProductCollection
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

        return new ProductCollection($products);
    }

    /**
     * Store a newly created resource in storage
     *
     * @param User $user
     * @param ProductStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(User $user,  ProductStore $request)
    {
        ### create new product
        $product = $this->productService->updateOrCreate(
            $user,
            $request->all(),
        );

        return $this->success([
            "msg" => trans("dashboard.success.product.create"),
            "data" => new ProductResource($product->load([
                "prices", "productInformation", "categories", "tags", "skills"
            ]))
        ]);
    }

    /**
     * Display the specified resource
     * @param User $user
     * @param Post $product
     * @return ProductResource
     */
    public function show(User $user, Post $product)
    {
        return new ProductResource($product->load([
            "prices", "productInformation", "categories", "tags", "skills"
        ]));
    }

    /**
     * Update the specified resource in storage
     * @param User $user
     * @param Post $product
     * @param ProductUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(User $user, Post $product, ProductUpdate $request)
    {

        ### update product
        $product = $this->productService->updateOrCreate(
            $user,
            $request->all(),
            $product
        );

        return $this->success([
            "msg" => trans("dashboard.success.product.update"),
            "data" => new ProductResource($product->load([
                "prices", "productInformation", "categories", "tags", "skills"
            ]))
        ]);
    }


    /**
     * Remove the specified resource from storage
     * @param User $user
     * @param Post $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user, Post $product)
    {
        $this->productService->delete($product);

        return $this->success([
            "msg" => trans("dashboard.success.product.delete")
        ]);
    }

    /**
     * restore single product
     *
     * @param User $user
     * @param Post $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(User $user, Post $product)
    {
        $this->productService->restore($product);

        return $this->success([
            "msg" => trans("dashboard.success.product.restore")
        ]);
    }

    /**
     * force delete single product
     *
     * @param User $user
     * @param Post $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function forceDelete(User $user, Post $product)
    {
        $this->productService->forceDelete($product);

        return $this->success([
            "msg" => trans("dashboard.success.product.forceDelete")
        ]);
    }
}

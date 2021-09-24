<?php

namespace App\Http\Controllers\Api\Post;

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
    protected
        $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
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

        return new ProductCollection($products);
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

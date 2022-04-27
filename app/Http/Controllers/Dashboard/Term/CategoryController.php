<?php

namespace App\Http\Controllers\Dashboard\Term;

use App\Models\Term;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryIndex;
use App\Http\Requests\Category\CategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Category\CategoryCollection;
use App\Services\Category\CategoryServiceInterface;

class CategoryController extends Controller
{

    public function __construct(
        protected CategoryServiceInterface $categoryService
    ){}

    /**
     * Display a listing of the resource
     * @param CategoryIndex $request
     * @return CategoryCollection
     */
    public function index(CategoryIndex $request)
    {
        $terms = $this->categoryService->list(
            $request->only([
                "name", "description", "slug", "color", "term_id"
            ])
        );

        return new CategoryCollection($terms);
    }

    /**
     * Store a newly created resource in storage
     * @param CategoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryRequest $request)
    {

        $category = $this->categoryService->updateOrCreate(
            $request->only([
                "color",
                "term_id",
                "slug",
                "translations",
                "thumbnail",
                "cover",
            ])
        );

        return $this->success([
            "msg" => trans("dashboard.success.category.create"),
            "data" => new CategoryResource($category->load("parent"))
        ]);
    }

    /**
     * Display the specified resource
     * @param Term $category
     * @return CategoryResource
     */
    public function show(Term $category)
    {
        return new CategoryResource($category->load("childrens", "parent"));
    }

    /**
     * Update the specified resource in storage
     * @param Term $category
     * @param CategoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Term $category, CategoryRequest $request)
    {
        $category = $this->categoryService->updateOrCreate(
            $request->only([
                "color",
                "term_id",
                "slug",
                "translations",
                "thumbnail",
                "cover",
            ]),
            $category
        );

        return
            $this->success([
                "msg" => trans("dashboard.success.category.update"),
                "data" => new CategoryResource($category->load("childrens", "parent"))
            ]);
    }

    /**
     * Remove the specified resource from storage
     * @param Term $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Term $category)
    {
        $this->categoryService->delete($category);
        return $this->success([
            "msg" => trans("dashboard.success.category.delete")
        ]);
    }
}

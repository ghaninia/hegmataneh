<?php

namespace App\Http\Controllers\Api\Term;

use App\Models\Term;
use App\Http\Controllers\Controller;
use App\Services\Category\CategoryService;
use App\Http\Requests\Category\CategoryIndex;
use App\Http\Requests\Category\CategoryStore;
use App\Http\Requests\Category\CategoryUpdate;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Category\CategoryCollection;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return CategoryIndex $request
     */
    public function index(CategoryIndex $request)
    {
        $terms = $this->categoryService->list(
            $request->only([
                "name", "description", "slug" , "color" , "term_id"
            ])
        );
        return new CategoryCollection($terms);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CategoryStore $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStore $request)
    {
        $category = $this->categoryService->create(
            $request->only([
                "color" ,
                "term_id" ,
                "name",
                "description",
                "slug"
            ])
        );

        return $this->success([
            "msg" => trans("dashboard.success.category.create"),
            "data" => new CategoryResource($category->load("parent"))
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Term $category
     * @return \Illuminate\Http\Response
     */
    public function show(Term $category)
    {
        return new CategoryResource($category->load("childrens" , "parent"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Term $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdate $request, Term $category)
    {
        $category = $this->categoryService->update($category, $request->only([
            "color" ,
            "term_id" ,
            "name",
            "description",
            "slug"
        ]));

        return
            $this->success([
                "msg" => trans("dashboard.success.category.update"),
                "data" => new CategoryResource($category->load("childrens" , "parent"))
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Term $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Term $category)
    {
        $this->categoryService->delete($category);
        return $this->success([
            "msg" => trans("dashboard.success.category.delete")
        ]);
    }
}

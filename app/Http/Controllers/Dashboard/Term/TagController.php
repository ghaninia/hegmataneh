<?php

namespace App\Http\Controllers\Dashboard\Term;

use App\Models\Term;
use App\Http\Requests\Tag\TagIndex;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\TagRequest;
use App\Http\Resources\Tag\TagResource;
use App\Http\Resources\Tag\TagCollection;
use App\Services\Tag\TagServiceInterface;

class TagController extends Controller
{
    public function __construct(
        protected TagServiceInterface $tagService
    ) {
    }

    /**
     * Display a listing of the resource.
     * @param TagIndex $request
     * @return TagCollection
     */
    public function index(TagIndex $request)
    {
        $terms = $this->tagService->list(
            $request->only([
                "id", "name", "description", "slug"
            ])
        );

        return new TagCollection($terms);
    }

    /**
     * Store a newly created resource in storage
     * @param TagRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TagRequest $request)
    {

        $tag = $this->tagService->updateOrCreate($request->all());

        return $this->success([
            "msg" => trans("dashboard.success.tag.create"),
            "data" => new TagResource($tag)
        ]);
    }

    /**
     * Display the specified resource
     * @param Term $tag
     * @return TagResource
     */
    public function show(Term $tag)
    {
        return new TagResource($tag);
    }

    /**
     * Update the specified resource in storage
     * @param Term $tag
     * @param TagRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Term $tag, TagRequest $request)
    {

        $tag = $this->tagService->updateOrCreate($request->all(), $tag);
        return
            $this->success([
                "msg" => trans("dashboard.success.tag.update"),
                "data" => new TagResource($tag)
            ]);
    }

    /**
     * Remove the specified resource from storage
     * @param Term $tag
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Term $tag)
    {
        $this->tagService->delete($tag);
        return $this->success([
            "msg" => trans("dashboard.success.tag.delete")
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api\Term;

use App\Models\Term;
use App\Services\Tag\TagService;
use App\Http\Requests\Tag\TagIndex;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\TagRequest;
use App\Services\Upload\UploadService;
use App\Http\Resources\Tag\TagResource;
use App\Http\Resources\Tag\TagCollection;

class TagController extends Controller
{
    protected $tagService, $uploadService;

    public function __construct(TagService $tagService, UploadService $uploadService)
    {
        $this->tagService = $tagService;
        $this->uploadService = $uploadService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TagIndex $request)
    {
        $terms = $this->tagService->list(
            $request->only([
                "name", "description", "slug"
            ])
        );
        return new TagCollection($terms);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        $tag = $this->tagService->updateOrCreate(
            $request->all()
        );

        return $this->success([
            "msg" => trans("dashboard.success.tag.create"),
            "data" => new TagResource($tag)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Term $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Term $tag)
    {
        return new TagResource($tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Term $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Term $tag, TagRequest $request)
    {

        $tag = $this->tagService->updateOrCreate($request->all() , $tag );
        return
            $this->success([
                "msg" => trans("dashboard.success.tag.update"),
                "data" => new TagResource($tag)
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Term $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Term $tag)
    {
        $this->tagService->delete($tag);
        return $this->success([
            "msg" => trans("dashboard.success.tag.delete")
        ]);
    }
}

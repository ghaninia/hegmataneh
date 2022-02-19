<?php

namespace App\Http\Controllers\Dashboard\Language;

use App\Models\Language;
use App\Http\Controllers\Controller;
use App\Services\Language\LanguageService;
use App\Http\Requests\Language\LanguageIndex;
use App\Http\Requests\Language\LanguageStore;
use App\Http\Requests\Language\LanguageUpdate;
use App\Http\Resources\Language\LanguageResource;
use App\Http\Resources\Language\LanguageCollection;

class LanguageController extends Controller
{
    protected $languageService;

    public function __construct(LanguageService $languageService)
    {
        $this->languageService = $languageService;
    }

    /**
     * Display a listing of the resource.
     * @param LanguageIndex $request
     * @return \Illuminate\Http\Response
     */
    public function index(LanguageIndex $request)
    {

        $languages = $this->languageService->list(
            $request->only([
                "name",
                "code",
                "direction"
            ]) ,
            $request->get("is_paginate" , false )
        );

        return new LanguageCollection($languages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  languageStore $request
     * @return \Illuminate\Http\Response
     */
    public function store(LanguageStore $request)
    {
        $language =
            $this->languageService->create($request->only([
                "name",
                "code",
                "direction"
            ]));

        return $this->success([
            "msg" => trans("dashboard.success.language.create"),
            "data" => new LanguageResource($language)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Language $language
     * @return \Illuminate\Http\Response
     */
    public function show(Language $language)
    {
        return new LanguageResource($language);
    }

    /**
     * Update the specified resource in storage.
     * @param  Language $language
     * @param  LanguageUpdate $request
     * @return \Illuminate\Http\Response
     */
    public function update(Language $language, LanguageUpdate $request)
    {
        $language =
            $this->languageService->update(
                $language,
                $request->only([
                    "name",
                    "code",
                    "direction"
                ])
            );

        return $this->success([
            "msg" => trans("dashboard.success.language.update"),
            "data" => new LanguageResource($language)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Language $language
     * @return \Illuminate\Http\Response
     */
    public function destroy(Language $language)
    {
        $this->languageService->delete($language);

        return $this->success([
            "msg" => trans("dashboard.success.language.delete")
        ]);
    }
}

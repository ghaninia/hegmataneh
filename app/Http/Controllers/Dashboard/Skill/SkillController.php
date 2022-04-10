<?php

namespace App\Http\Controllers\Dashboard\Skill;

use App\Models\Skill;
use App\Http\Controllers\Controller;
use App\Services\Skill\SkillService;
use App\Http\Requests\Skill\SkillIndex;
use App\Http\Requests\Skill\SkillRequest;
use App\Http\Resources\Skill\SkillResource;
use App\Http\Resources\Skill\SkillCollection;

class SkillController extends Controller
{

    public function __construct(
        protected SkillService $skillService
    ){}

    /**
     * Display a listing of the resource
     * @param SkillIndex $request
     * @return SkillCollection
     */
    public function index(SkillIndex $request)
    {

        $skills = $this->skillService->list(
            $request->only([
                "name",
                "description"
            ])
        );

        return new SkillCollection($skills);
    }

    /**
     * Store a newly created resource in storage
     * @param SkillRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SkillRequest $request)
    {
        $skill =
            $this->skillService->updateOrCreate($request->all());

        return $this->success([
            "msg" => trans("dashboard.success.skill.create"),
            "data" => new SkillResource($skill)
        ]);
    }

    /**
     * Display the specified resource
     * @param Skill $skill
     * @return SkillResource
     */
    public function show(Skill $skill)
    {
        return new SkillResource($skill);
    }

    /**
     * Update the specified resource in storage
     * @param Skill $skill
     * @param SkillRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Skill $skill, SkillRequest $request)
    {
        $skill =
            $this->skillService->updateOrCreate(
                $request->all(),
                $skill
            );

        return $this->success([
            "msg" => trans("dashboard.success.skill.update"),
            "data" => new SkillResource($skill)
        ]);
    }

    /**
     * Remove the specified resource from storage
     * @param Skill $skill
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Skill $skill)
    {
        $this->skillService->delete($skill);

        return $this->success([
            "msg" => trans("dashboard.success.skill.delete")
        ]);
    }
}

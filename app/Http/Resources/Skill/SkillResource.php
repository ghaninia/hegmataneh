<?php

namespace App\Http\Resources\Skill;

use Illuminate\Http\Resources\Json\JsonResource;

class SkillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id ,
            'title_fa' => $this->title_fa ,
            'title_en' => $this->title_en ,
            'icon' => $this->icon ,
        ];
    }
}

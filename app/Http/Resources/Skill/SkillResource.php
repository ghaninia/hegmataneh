<?php

namespace App\Http\Resources\Skill;

use App\Http\Resources\Slug\SlugCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Translation\TranslationCollection;

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
            "id" => $this->id,
            'icon' => $this->icon,

            "translations" => new TranslationCollection($this->whenLoaded("translations")),
            "slugs" => new SlugCollection($this->whenLoaded("slugs")),
        ];
    }
}

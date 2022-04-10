<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\Slug\SlugCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Translation\TranslationCollection;

class CategoryResource extends JsonResource
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
            "color" => $this->color,
            "created_at" => $this->created_at,
            "parent" => new CategoryResource($this->whenLoaded("parent")),
            "childrens" => new CategoryCollection($this->whenLoaded("childrens")),

            "translations" => new TranslationCollection($this->whenLoaded("translations")),
            "slugs" => new SlugCollection($this->whenLoaded("slugs")) ,
        ];
    }
}

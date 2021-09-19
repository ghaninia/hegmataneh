<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\Translation\TranslationCollection;
use App\Http\Resources\Translation\TranslationResource;
use Illuminate\Http\Resources\Json\JsonResource;

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
            "name" => $this->name,
            "color" => $this->color,
            "slug" => $this->slug,
            "description" => $this->description,
            "created_at" => $this->created_at,
            "parent" => new CategoryResource($this->whenLoaded("parent")),
            "childrens" => new CategoryCollection($this->whenLoaded("childrens")),
            // "translations" => TranslationResource::collection( $this->translations )->collection->groupBy([
            //     "language.code" , "field"
            // ])
        ];
    }
}

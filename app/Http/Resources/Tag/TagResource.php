<?php

namespace App\Http\Resources\Tag;

use App\Http\Resources\Slug\SlugCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Translation\TranslationCollection;

class TagResource extends JsonResource
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
            "created_at" => $this->created_at ,
            
            "translations" => new TranslationCollection($this->whenLoaded("translations")),
            "slugs" => new SlugCollection($this->whenLoaded("slugs"))
        ];
    }
}

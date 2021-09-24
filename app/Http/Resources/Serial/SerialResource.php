<?php

namespace App\Http\Resources\Serial;

use App\Http\Resources\Tag\TagCollection;
use App\Http\Resources\Slug\SlugCollection;
use App\Http\Resources\Price\PriceCollection;
use App\Http\Resources\Episode\EpisodeResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Translation\TranslationCollection;

class SerialResource extends JsonResource
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
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "episodes" => EpisodeResource::collection($this->whenLoaded("episodes")),
            "prices" => new PriceCollection($this->whenLoaded("prices")),
            "translations" => new TranslationCollection($this->whenLoaded("translations")),
            "slugs" => new SlugCollection($this->whenLoaded("slugs")),
            "categories"  => new CategoryCollection($this->whenLoaded("categories")),
            "tags"  => new TagCollection($this->whenLoaded("tags")),
        ];
    }
}

<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Tag\TagCollection;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\Price\PriceResource;
use App\Http\Resources\Skill\SkillCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Product\Information\ProductInformationResource;

class ProductResource extends JsonResource
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
            "type" => $this->type,
            "status"  => $this->status,
            "comment_status" => $this->comment_status,
            "vote_status" => $this->vote_status,
            "development" => $this->development,
            "title" => $this->title,
            "slug" => $this->slug,
            "content" => $this->content,
            "excerpt" => $this->excerpt,
            "faq" => $this->faq,
            "theme" => $this->theme,

            "published_at" => $this->published_at,
            "created_at" => $this->created_at,
            "deleted_at" => $this->deleted_at,

            "user"  => new UserResource($this->whenLoaded("user")),
            "price" => new PriceResource($this->whenLoaded("price")),
            "information" => new ProductInformationResource($this->whenLoaded("productInformation")),

            "tags" => new TagCollection($this->whenLoaded("tags")),
            "categories" => new CategoryCollection($this->whenLoaded("categories")),
            "skills" => new SkillCollection($this->whenLoaded("skills")),
        ];
    }
}

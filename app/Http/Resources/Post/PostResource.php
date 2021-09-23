<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Slug\SlugCollection;
use App\Http\Resources\Tag\TagCollection;
use App\Http\Resources\Translation\TranslationCollection;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            "status"  => $this->status,
            "comment_status"  => (bool) $this->comment_status,
            "vote_status"  => (bool) $this->vote_status,
            "format" => $this->format,
            "published_at" => $this->published_at,
            "created_at" => $this->created_at,

            "user"  => new UserResource($this->whenLoaded("user")),
            "categories"  => new CategoryCollection($this->whenLoaded("categories")),
            "tags"  => new TagCollection($this->whenLoaded("tags")),

            "views_count" => $this->when(isset($this->views_count), $this->views_count),
            "votes_count" => $this->when(isset($this->votes_count), $this->votes_count),
            "comments_count" => $this->when(isset($this->comments_count), $this->comments_count),
            
            "translations" => new TranslationCollection($this->whenLoaded("translations")),
            "slugs" => new SlugCollection($this->whenLoaded("slugs"))
        ];
    }
}

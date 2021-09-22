<?php

namespace App\Http\Resources\Page;

use App\Http\Resources\User\UserResource;
use App\Http\Resources\Slug\SlugCollection;
use App\Http\Resources\Slug\SlugResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Translation\TranslationCollection;

class PageResource extends JsonResource
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
            "format" => $this->format,
            "theme" => $this->theme,
            "development" => $this->development,
            "theme" => $this->theme,
            "created_at" => $this->created_at,
            "user"  => new UserResource($this->whenLoaded("user")),

            "views_count" => $this->when(isset($this->views_count), $this->views_count),
            "votes_count" => $this->when(isset($this->votes_count), $this->votes_count),
            "comments_count" => $this->when(isset($this->comments_count), $this->comments_count),

            "translations" => new TranslationCollection($this->whenLoaded("translations")),
            "slugs" => new SlugCollection($this->whenLoaded("slugs"))
        ];
    }
}

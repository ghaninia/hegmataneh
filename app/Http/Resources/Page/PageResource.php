<?php

namespace App\Http\Resources\Page;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

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
            "title" => $this->title,
            "goal_post" => $this->goal_post,
            "slug" => $this->slug,
            "content" => $this->content,
            "excerpt" => $this->excerpt,
            "faq" => $this->faq,
            "theme" => $this->theme,
            "created_at" => $this->created_at,
            "user"  => new UserResource($this->whenLoaded("user")),

            "views_count" => $this->when(isset($this->views_count), $this->views_count),
            "votes_count" => $this->when(isset($this->votes_count), $this->votes_count),
            "comments_count" => $this->when(isset($this->comments_count), $this->comments_count),

        ];
    }
}

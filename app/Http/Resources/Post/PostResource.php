<?php

namespace App\Http\Resources\Post;

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
            "status"  => $this->status ,
            "comment_status"  => (bool) $this->comment_status,
            "vote_status"  => (bool) $this->vote_status,
            "format" => $this->format,
            "title"  => $this->title,
            "goal_post"  => $this->goal_post,
            "slug"  => $this->slug,
            "content"  => $this->content,
            "excerpt"  => $this->excerpt,
            "published_at" => $this->published_at ,
            "created_at" => $this->created_at,
            "user"  => new UserResource($this->whenLoaded("user"))
        ];
    }
}

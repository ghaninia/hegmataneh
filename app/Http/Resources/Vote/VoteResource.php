<?php

namespace App\Http\Resources\Vote;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class VoteResource extends JsonResource
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
            'ipv4' => $this->ipv4,
            'vote' => $this->vote,
            'user' => new UserResource($this->whenLoaded("user")),
            'post' => new UserResource($this->whenLoaded("post")),
            "created_at" => $this->created_at
        ];
    }
}

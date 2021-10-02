<?php

namespace App\Http\Resources\View;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ViewResource extends JsonResource
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
            "ipv4" => $this->ipv4,
            "viewable" => $this->whenLoaded("viewable"),
            "user" => new UserResource($this->whenLoaded("user")),
            "created_at" => $this->created_at
        ];
    }
}

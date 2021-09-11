<?php

namespace App\Http\Resources\Episode;

use Illuminate\Http\Resources\Json\JsonResource;

class EpisodeResource extends JsonResource
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

            "title" => $this->title,
            "is_locked" => $this->is_locked,
            "priority" => $this->priority,
            "description" => $this->description,

            "post" => $this->whenLoaded("post"),
            "serial" => $this->whenLoaded("serial"),

        ];
    }
}

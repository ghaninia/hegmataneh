<?php

namespace App\Http\Resources\Episode;

use App\Http\Resources\Post\PostResource;
use App\Http\Resources\Serial\SerialResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Translation\TranslationCollection;

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
            "is_locked" => $this->is_locked,
            "priority" => $this->priority,
            "post" => new PostResource($this->whenLoaded("post")),
            "serial" => new SerialResource($this->whenLoaded("serial")),
            "translations" => new TranslationCollection($this->whenLoaded("translations")),
        ];
    }
}

<?php

namespace App\Http\Resources\Serial;

use App\Http\Resources\Price\PriceResource;
use App\Http\Resources\Episode\EpisodeResource;
use Illuminate\Http\Resources\Json\JsonResource;

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
            "title" => $this->title,
            "description" => $this->description,
            "episodes" => EpisodeResource::collection(
                $this->whenLoaded("episodes")
            ),
            "price" => PriceResource::collection($this->whenLoaded("prices")),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}

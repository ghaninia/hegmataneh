<?php

namespace App\Http\Resources\Portfolio;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Translation\TranslationCollection;

class PortfolioResource extends JsonResource
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
            "demo" => $this->demo,
            "percent" => $this->percent,
            "launched_at" => $this->launched_at,
            "created_at" => $this->created_at,
            "user" => new UserResource($this->whenLoaded("user")),
            "translations" => new TranslationCollection($this->whenLoaded("translations")),
        ];
    }
}

<?php

namespace App\Http\Resources\Slug;

use Illuminate\Http\Resources\Json\JsonResource;

class SlugResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "slug" => $this->slug 
        ];
    }
}

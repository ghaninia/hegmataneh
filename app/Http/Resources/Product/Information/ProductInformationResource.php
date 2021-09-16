<?php

namespace App\Http\Resources\Product\Information;

use App\Http\Resources\Product\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductInformationResource extends JsonResource
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
            "maximum_sell" => $this->maximum_sell,
            "expire_day" => $this->expire_day,
            "download_limit" => $this->download_limit,
            "created_at" => $this->created_at,
            "post" => new ProductResource($this->whenLoaded("post")),
        ];
    }
}

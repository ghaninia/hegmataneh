<?php

namespace App\Http\Resources\Price;

use Illuminate\Http\Resources\Json\JsonResource;

class PriceResource extends JsonResource
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
            "price" => $this->price,
            "amazing_status" => $this->amazing_status,
            "amazing_price" => $this->amazing_price,
            "amazing_from_date" => $this->amazing_from_date,
            "amazing_to_date" => $this->amazing_to_date,
        ];
    }
}

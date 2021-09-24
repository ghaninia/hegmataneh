<?php

namespace App\Http\Resources\Price;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PriceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->groupBy("currency.code");
    }
}

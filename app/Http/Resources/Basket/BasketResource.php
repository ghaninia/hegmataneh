<?php

namespace App\Http\Resources\Basket;

use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Serial\SerialCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class BasketResource extends JsonResource
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
            "total_unit" => $this->basketables->sum("unit") ,
            "basket" => [
                "serials" => new SerialCollection($this->serials) ,
                "products" => new ProductCollection($this->products) ,
            ]
        ];
    }
}
